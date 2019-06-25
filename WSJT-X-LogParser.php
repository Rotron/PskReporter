<?php
   function log_reader(){
   $pattern = "/.*CQ.*/m"; 
   $logfile = preg_grep($pattern, file('/Users/xxxxxx/Library/Application Support/WSJT-X/ALL.txt'));
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

   echo $day ."/". $month ."/". $year .",";
   echo $hour .":". $minutes .":". $seconds ."";

  $logfile = substr($logfile, 13);
   echo $logfile."\n";
  }
}


while(true){
log_reader();
sleep(15);
}

//Example of output: 19/06/25,14:54:45,7.074,Rx,FT8,-5,-1.4,1543,CQ,WA0SD,DN84

?>
