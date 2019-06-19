
<?php
//Reduce errors
error_reporting(~E_WARNING);

//Create a UDP socket
if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo"Socket created\n";

// Bind the source address
if( !socket_bind($sock,"0.0.0.0" , 14739) )
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    
    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo"Socket bind OK \n";

//Do some communication, this loop can handle multiple clients
while(1)
{
	echo"\n\n Waiting for data ... \n\n";
	
	//Receive some data
	$r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);

	echo"$remote_ip : $remote_port -- \n\n\n";
	echo"Raw Data: \n\n";
	echo $buf ."\n\n\n\n\n";
	echo"HEX Data: \n\n";
	echo bin2hex($buf) ."\n";;
	
	//Send back the data to the client
	socket_sendto($sock,"OK" . $buf , 100 , 0 , $remote_ip , $remote_port);
}

socket_close($sock);
?>
