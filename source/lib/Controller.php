<?php
use \ArrayAccess;
use \Slim;
use \Opensoft\SimpleSerializer\Serializer;


class Controller
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
     * @var ControllerServiceProviderInterface
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
     * @param Slim\Slim                             $application
     * @param array                                 $globalViewScope    Scope to share through all views
     * @param ControllerServiceProviderInterface    $serviceProvider
     */
    public function __construct(Slim\Slim $application,
                                $globalViewScope,
                                ControllerServiceProviderInterface $serviceProvider)
    {
        $this->app             = $application;
        $this->globalViewScope = $globalViewScope;
        $this->serviceProvider = $serviceProvider;
        
        $this->errors               = array();
        $this->isJsonResponse       = true;
        $this->errorHandlerTemplate = null;

        $this->app->error(array($this, 'errorHandler'));
    }

    protected function app()
    {
        return $this->app;
    }

    protected function environment()
    {
        return $this->app()->environment();
    }
    
    protected function router()
    {
        return $this->app()->router();
    }

    protected function request()
    {
        return $this->app()->request();
    }

    protected function response()
    {
        return $this->app()->response();
    }

    protected function view()
    {
        return $this->app()->view();
    }

    protected function session()
    {
        return $this->serviceProvider->getSession();
    }

    protected function serializer()
    {
        $serializer = $this->serviceProvider->getSerializer();
        $serializer->setGroups(array('default'));
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
        return $this->environment()['slim.input'];
    }

    protected function jsonResponse($data, $status=0, $message=null)
    {
        if ($status === 0 && count($this->errors) > 0) {
            $status = -1;
        }
        $response = array(
            'data'          => $data,
            'status'        => $status,
            'message'       => $message,
            'errors'        => $this->errors
        );
        $this->app()->contentType('application/json;charset=utf-8');
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
