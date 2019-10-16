<?php
$host    = "ZG00eC5kZG5zLm5ldA==";
$port    = 8500;
$message = "callsign \r\n";
//echo "Message To server :".$message;
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, base64_decode($host), $port) or die("Could not connect to server\n");  
// send string to server

// get server response
//$result = socket_read ($socket, 1024) or die("Could not read server response\n");
//echo "Reply From Server  :".$result;

socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");





$result = socket_read ($socket, 1024) or die("Could not read server response\n");
$result2 = array($result);
$result = array_splice($result2, 29, 30);



while (true) {


// get server response
$result = socket_read ($socket, 1024) or die("Could not read server response\n");


$result = preg_replace('/.*arc6>/', '', $result);
$result = preg_replace('/.*HELP/', '', $result);
$result = preg_replace('/.*8500/', '', $result);
$result = preg_replace('/.*5123/', '', $result);
$result = preg_replace('/.*callsign/', '', $result);
$result = str_replace("DX de ","",$result);
$result = str_replace(":","",$result);


$result = str_replace("<>"," ",$result);

$result = preg_replace('/\s+/', ', ', $result);

//echo "Reply From Server  :".$result;
echo rtrim($result,',  ');

echo "\n";

}

// close socket
//socket_close($socket);



?>



