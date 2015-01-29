<?php
use ServiceLocator;

class Controller
{
    protected $app;
    protected $view;
    protected $router;
    protected $request;
    protected $response;
    protected $serializer;
    protected $config;

    protected $errors;

    protected $isJsonResponse;
    protected $errorHandlerTemplate;


    public function __construct()
    {
        $this->app                  = $this->getService('app');
        $this->view                 = $this->app->view();
        $this->router               = $this->app->router();
        $this->request              = $this->app->request();
        $this->response             = $this->app->response();
        $this->serializer           = $this->getService('serializer');
        $this->config               = $this->getService('config');
        
        $this->isJsonResponse       = true;
        $this->errorHandlerTemplate = null;
        
        $this->errors               = array();

        $this->serializer->setGroups(array('default'));
    }

    public final function dispatch($action, $argv)
    {
        $this->app->error(array($this, 'errorHandler'));
        $this->beforeDispatch();
        call_user_func_array(array($this, $action), $argv);
        $this->afterDispatch();
    }

    protected function getService($name)
    {
        return ServiceLocator::getInstance()->offsetGet($name);
    }

    protected function beforeDispatch()
    {
    }
    
    protected function afterDispatch()
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

    public function isNotJsonResponse($errorHandlerTemplate)
    {
        $this->errorHandlerTemplate = $errorHandlerTemplate;
        $this->isJsonResponse       = false;
    }

    public function isJsonResponse()
    {
        $this->isJsonResponse = true;
    }

    public function jsonRequest()
    {
        $env = $this->app->environment();
        return $env['slim.input'];
    }

    public function jsonResponse($data, $status=0, $message=null)
    {
        if ($status === 0 && count($this->errors) > 0) {
            $status = -1;
        }
        $response = array(
            'data'          => $data,
            'status'        => $status,
            'message'       => $message,
            'errors'        => $this->errors,
            'executionTime' => $this->getService('timer')->stop()  
        );
        $this->app->contentType('application/json;charset=utf-8');
        $this->response->setBody($this->serializer->serialize($response));
    }

    protected function render($template, $scope = array(), $status = null)
    {
        if (isset($scope['errors'])) {
            $scope['errors'] = array_merge_recursive($scope['errors'], $this->errors);
        } else {
            $scope['errors'] = $this->errors;
        }
        foreach ($scope['errors'] as &$error) {
            if ($error['message'] instanceof \Exception) $error['message'] = $error['message']->getMessage();
            unset($error);
        }
        
        if (isset($scope['assets'])) {
            $scope['assets'] = array_merge_recursive($scope['assets'], $this->getService('assets'));
        } else {
            $scope['assets'] = $this->getService('assets');
        }

        $scope = array_merge($scope, array(
            'URL'             => $this->getService('URL'),
            'SCRIPT_URL'      => $this->getService('SCRIPT_URL'),
            'PUBLIC_ASSETS'   => $this->getService('PUBLIC_ASSETS'),
            'PUBLIC_UPLOADS'  => $this->getService('PUBLIC_UPLOADS')
        ));

        \Twig\Extensions\Filters::register($this->view->getInstance());

        $this->app->contentType('text/html;charset=utf-8');

        $this->app->render($template, $scope, $status);
    }

}
