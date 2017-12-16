<?php

require_once('Classes/Request.php');

class IotServer
{
    const HOST = "127.0.0.1";
    const PORT = "5000";

    private $socket;

    public function init()
    {
        // error_reporting(~E_WARNING);
        set_time_limit(0);

        // Create TCP IP socket
        $this->createSocket();
        // Bind socket to the port
        $this->bindSocket();
    }
    public function run()
    {
        $this->listen();

        // main loop
        while(true) {
            $client = socket_accept($this->socket);
            // read client input
            $rawRequest = socket_read($client, 1024);

            $request = new Request($rawRequest);

            $app = $this->getApp($request->app);

            $app->handleRequest($request);

            // reverse client input and send back
            socket_write($client, $rawRequest, strlen ($rawRequest));
        }


    }

    private function createSocket()
    {
        echo 'Creating socket ...' . "\r\n";
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);
        if(!$socket) {
            throw new Exception(socket_last_error($this->socket));
            echo 'Could not start server, exiting ...' . " \r\n";
            exit;
        } else {
            $this->socket = $socket;
            echo 'OK!' . "\r\n";
        }
    }

    private function bindSocket()
    {
        echo 'Binding socket ...' . "\r\n";
        if(!socket_bind($this->socket, self::HOST, self::PORT)) {
            throw new Exception(socket_last_error($this->socket));
            echo 'Could not bind socket, exiting' . "\r\n";
            exit;
        } else {
            echo 'OK!' . "\r\n";
        }
    }

    private function listen()
    {
        echo 'Listening ...';
        if(!socket_listen($this->socket, 10)) {
            throw new Exception(socket_last_error($this->socket));
            echo 'Socket could not be set to listening' . "\r\n";
            exit;
        }
        echo 'Server is listening !' . "\r\n";
        echo 'Waiting for connections' . "\r\n";
    }

    private function getApp($appName)
    {
        $appDir = ucfirst($appName);
        $path = dirname(__FILE__) . "/../App/$appDir/App.php";
        require $path;
        $app = new App();

        return $app;
    }

}
