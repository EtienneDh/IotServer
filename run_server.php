<?php
require_once('Classes/IotServer.php');

$server = new IotServer();

// Initialize server
echo 'Initializing server ...' . "\r\n";
try {
    $server->init();
} catch(Exception $e) {
    echo $e;
}




$server->run();
