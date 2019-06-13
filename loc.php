<?php


//$loc = $user_data['user_loc'];

$loc="IK2DUW";

$lat= 
(ord(substr($loc, 1, 1))-65) * 10 - 90 +
(ord(substr($loc, 3, 1))-48) +
(ord(substr($loc, 5, 1))-65) / 24 + 1/48;
$lng= 
(ord(substr($loc, 0, 1))-65) * 20 - 180 +
(ord(substr($loc, 2, 1))-48) * 2 +
(ord(substr($loc, 4, 1))-65) / 12 + 1/24;


echo $lat;
echo "     ";
echo $lng;

?>