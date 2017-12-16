<?php

class Request
{
    public $app;
    public $controller;
    public $action;
    public $params = array();


    public function __construct($rawRequest)
    {
        $requestParams = explode("/", $rawRequest);

        $this->app = $requestParams[0];
        $this->controller = $requestParams[1];
        $this->action = $requestParams[2];

        for($i = 3; $i < count($requestParams); $i++) {
            $this->params[] = $requestParams[$i];
        }

        return $this;
    }
}
