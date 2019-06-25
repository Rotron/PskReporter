
<?php

function locator($loc){

$lat= (ord(substr($loc, 1, 1))-65) * 10 - 90 + (ord(substr($loc, 3, 1))-48) + (ord(substr($loc, 5, 1))-65) / 24 + 1/48;
$lng= (ord(substr($loc, 0, 1))-65) * 20 - 180 + (ord(substr($loc, 2, 1))-48) * 2 + (ord(substr($loc, 4, 1))-65) / 12 + 1/24;

return $lat .", ".$lng;

}


function log_reader(){

$pattern = "/.*CQ.*/m"; 

$logfile = preg_grep($pattern, file('/Users/federicosacca/Library/Application Support/WSJT-X/ALL.txt'));


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

		 $array =  (explode(",",$logfile));

		 $conta = count($array);

		if ($conta === 11){
			//echo "11"."\n";
		    echo locator($array[10]) ."\n";
		} else{

			//echo "12"."\n";
			echo locator($array[11]) ."\n";
			
		}
	}
}




while(true){
	system('clear');

	log_reader();
	sleep(15);
}


?>





//Test coordinates on map: https://www.gpsvisualizer.com/map?output_geocoder
