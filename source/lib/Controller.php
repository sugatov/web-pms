<?php
use ArrayAccess;
use Slim;
use Opensoft\SimpleSerializer\Serializer;

abstract class Controller
{
    /**
     * @var Slim\Slim
     */
    protected $app;
    /**
     * @var array
     */
    protected $globalViewScope;
    /**
     * @var ServiceProviderInterface
     */
    protected $serviceProvider;

    /**
     * @var array
     */
    protected $errors;
    /**
     * @var bool
     */
    protected $isJsonResponse;
    /**
     * @var string
     */
    protected $errorHandlerTemplate;


    /**
     * @param Slim\Slim                   $application
     * @param array                       $globalViewScope    Scope to share through all views
     * @param ServiceProviderInterface    $serviceProvider
     */
    public function __construct(Slim\Slim $application,
                                $globalViewScope,
                                ServiceProviderInterface $serviceProvider)
    {
        $this->app             = $application;
        $this->globalViewScope = $globalViewScope;
        $this->serviceProvider = $serviceProvider;

        $this->errors               = array();
        $this->isJsonResponse       = true;
        $this->errorHandlerTemplate = null;

        $this->app->error(array($this, 'errorHandler'));
    }

    /**
     * @return Slim\Slim
     */
    protected function app()
    {
        return $this->app;
    }

    /**
     * @return Slim\Environment
     */
    protected function environment()
    {
        return $this->app()->environment();
    }

    /**
     * @return Slim\Router
     */
    protected function router()
    {
        return $this->app()->router();
    }

    /**
     * @return Slim\Http\Request
     */
    protected function request()
    {
        return $this->app()->request();
    }

    /**
     * @return Slim\Http\Response
     */
    protected function response()
    {
        return $this->app()->response();
    }

    /**
     * @return Slim\View
     */
    protected function view()
    {
        return $this->app()->view();
    }

    /**
     * @return ArrayAccess
     */
    protected function session()
    {
        return $this->serviceProvider->getSession();
    }

    /**
     * @return Serializer
     */
    protected function serializer()
    {
        $serializer = $this->serviceProvider->getSerializer();
        return $serializer;
    }



    public function beforeDispatch()
    {
    }

    public function afterDispatch()
    {
    }

    protected function addError($error, $code = null)
    {
        $err = array(
            'code'    => $code,
            'message' => $error
        );
        array_push($this->errors, $err);
    }

    public function errorHandler($error)
    {
        $code = null;
        if ($error instanceof \Exception) {
            $code = $error->getCode();
            $error = $error->getMessage();
        } elseif (!is_string($error)) {
            $error = (string) $error;
        }

        $this->addError($error, $code);

        if ($this->isJsonResponse) {
            $this->jsonResponse(null);
        } else {
            $this->render($this->errorHandlerTemplate);
        }
    }

    protected function isJsonResponse($switch=null, $errorHandlerTemplate=null)
    {
        if (is_bool($switch)) {
            $this->isJsonResponse = $switch;
            if ($switch === false) {
                if (empty($errorHandlerTemplate)) {
                    throw new \RuntimeException('You should provide an error handler template to switch JSON response off!');
                }
                $this->errorHandlerTemplate = $errorHandlerTemplate;
            }
        }
        return $this->isJsonResponse;
    }

    protected function getRawInput()
    {
        // return $this->environment()['slim.input'];
        $env = $this->environment();
        return $env['slim.input'];
    }

    protected function jsonResponse($data, $status = 200, $message = null)
    {
        if ($status === 200 && count($this->errors) > 0) {
            $status = 500;
        }
        $response = array(
            'data'          => $data,
            'status'        => $status,
            'message'       => $message,
            'errors'        => $this->errors
        );
        $this->app()->contentType('application/json;charset=utf-8');
        $this->response()->setStatus($status);
        $this->response()->setBody($this->serializer()->serialize($response));
    }

    protected function render($template, $scope = array(), $status = null)
    {
        $scope = array_merge_recursive($this->globalViewScope, $scope);
        if (isset($scope['errors'])) {
            $scope['errors'] = array_merge_recursive($scope['errors'], $this->errors);
        } else {
            $scope['errors'] = $this->errors;
        }
        foreach ($scope['errors'] as &$error) {
            if ($error['message'] instanceof \Exception) {
                $error['message'] = $error['message']->getMessage();
                $error['code']    = $error['message']->getCode();
            }
            unset($error);
        }
        $this->app()->contentType('text/html;charset=utf-8');
        $this->app()->render($template, $scope, $status);
    }

}
