<?php

require 'AppInterface.php';

abstract class BaseApp implements AppInterface
{
    public function handleRequest($request)
    {
        $controller = $request->controller;
        $method = $request->action . "Action";
        $params = $request->params;

        echo 'request handled' . "\n";

        if(method_exists($this, $method)) {
            $this->$method(implode(",", $params));
        } else {
            exit("L'application n'implante pas la méthode: $method");
        }
    }
}
