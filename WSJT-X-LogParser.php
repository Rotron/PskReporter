<?php
function log_reader(){
$pattern = "/.*CQ.*/m"; 

$logfile = preg_grep($pattern, file('/Users/homedirectory/Library/Application Support/WSJT-X/ALL.txt'));

$logfile = preg_replace('/\s+/m', ',', $logfile);


// iterate through the list.
foreach($logfile as $ora_book) {

 $logfile = rtrim($ora_book, ',');

 $date = substr($logfile, 0, 6 );
 $day =  substr($date, 0, 2 );
 $month =  substr($date, 2, 2 );
 $year =  substr($date, 4, 2 );

 
 $time = substr($logfile, 7, 6 );
 $hour = substr($logfile, 7, 2 );
 $minutes = substr($logfile, 9, 2 );
 $seconds = substr($logfile, 11, 2 );


$logfile = $day ."/". $month ."/". $year ."," . $hour .":". $minutes .":". $seconds ."". substr($logfile, 13);

 print_r (explode(",",$logfile));
}



}


while(true){
log_reader();
sleep(15);
}


?>
