<?php

require dirname(__FILE__) . "/../../Classes/BaseApp.php";;

class App extends BaseApp
{
    /**
     * route = xmastree/script/run/script.py
     */
    public function runAction($script)
    {
        exit("runnin $script");
    }
}
