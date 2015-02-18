<?php
use \ArrayAccess;
use \Timer;
use \Slim;
use \Opensoft\SimpleSerializer\Serializer;


class Controller
{
    /**
     * @var Slim\Slim
     */
    protected $app;
    /**
     * @var Slim\Environment
     */
    protected $environment;
    /**
     * @var Slim\View
     */
    protected $view;
    /**
     * @var Slim\Router
     */
    protected $router;
    /**
     * @var Slim\Http\Request
     */
    protected $request;
    /**
     * @var Slim\Http\Response
     */
    protected $response;
    /**
     * @var Serializer
     */
    protected $serializer;
    /**
     * @var Timer
     */
    protected $timer;
    /**
     * @var ArrayAccess
     */
    protected $session;

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
     * @var array
     */
    protected $globalViewScope;


    /**
     * @param Slim\Slim     $application
     * @param Serializer    $serializer
     * @param Timer         $timer
     * @param ArrayAccess   $session
     * @param array         $globalViewScope    Scope to share through all views
     */
    public function __construct(Slim\Slim $application, Serializer $serializer, Timer $timer, ArrayAccess $session, $globalViewScope)
    {
        $this->app                  = $application;
        $this->environment          = $this->app->environment();
        $this->view                 = $this->app->view();
        $this->router               = $this->app->router();
        $this->request              = $this->app->request();
        $this->response             = $this->app->response();
        $this->serializer           = $serializer;
        $this->timer                = $timer;
        $this->session              = $session;
        
        $this->isJsonResponse       = true;
        $this->errorHandlerTemplate = null;
        $this->errors               = array();
        $this->globalViewScope      = $globalViewScope;

        $this->serializer->setGroups(array('default'));
        $this->app->error(array($this, 'errorHandler'));
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
            if ($switch === true) {
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
        return $this->environment['slim.input'];
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
            'errors'        => $this->errors,
            'executionTime' => $this->timer->stop()
        );
        $this->app->contentType('application/json;charset=utf-8');
        $this->response->setBody($this->serializer->serialize($response));
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
        $this->app->contentType('text/html;charset=utf-8');
        $this->app->render($template, $scope, $status);
    }

}
