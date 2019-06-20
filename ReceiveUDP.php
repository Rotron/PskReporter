<?php
error_reporting(E_ALL | E_STRICT);

    //Reduce errors
    error_reporting(~E_WARNING);




function hex2str($hex) {
    $str = '';
    for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
    return $str;
}



    //Create a UDP socket
    if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);

        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }

    echo "Socket created \n";

    // Bind the source address
    if( !socket_bind($sock, "127.0.0.1" , 2237) )
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);

        die("Could not bind socket : [$errorcode] $errormsg \n");
    }

    echo "Socket bind OK \n";

    //Do some communication, this loop can handle multiple clients
    while(1)
    {
        //echo "\n Waiting for data ... \n";

        //Receive some data
        $r = socket_recvfrom($sock, $buf, 1024, 0, $remote_ip, $remote_port);

      //  $buffer = str_replace("????WSJT-X?!??????????"," ",$buf);



        echo  $buf ."\n";
      	file_put_contents("logs.txt", "\xEF\xBB\xBF".  $buf, FILE_APPEND | LOCK_EX); 
 		//$myfile = file_put_contents('logs.txt', '\xEF\xBB\xBF'. $buf.PHP_EOL , FILE_APPEND | LOCK_EX);


            //Send back the data to the client
        //socket_sendto($sock, "OK " . $buf , 100 , 0 , $remote_ip , $remote_port);

    }

    socket_close($sock);

?>
