<!DOCTYPE html>
<html>
<head>
   
   <title>PSK Reporter</title>

   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>


   <style>
      html, body {
         height: 100%;
         margin: 0;
      }
      #map {
         width: 100%;
         height: 100%;
      }
   </style>

   
</head>
<body onbeforeunload="return myFunction()">

<div id='map'></div>

<?php

$string = @file_get_contents("https://pskreporter.info/cgi-bin/pskquery5.pl?encap=1&callback=doNothing&senderCallsign=m2xxx");

if ($string === FALSE) { 
   echo "TRY IN 5 MINUTES";
} else { 
 suca($string);
} 




function suca($string)
{
// remove all but doNothing
$string = strstr($string, "{");
$string = substr($string, 0, strpos($string, ");"));
$results = json_decode($string, TRUE);
$validRows = array();
foreach ($results['receptionReport'] as $row)
{
   // pull out FT8 and JT65 spots from the stream
   if ($row['mode'] == "FT8" || $row['mode'] == "JS8")
   {
      $spot = array();






      $spot['locator'] = $row['receiverLocator'];
      $spot['op'] = $row['senderCallsign'];
      $spot['dx'] = $row['receiverCallsign'];
      $spot['freq'] = $row['frequency'] / 1000.0;
      $spot['mode'] = $row['mode'];
      $spot['sNR'] = $row['sNR'];
      $spot['time'] = $row['flowStartSeconds'];
      array_push($validRows, $spot);
   }
}
?>

<script>
   var map = L.map('map').setView([51.5, -0.09], 13);

   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
   }).addTo(map);

   var LeafIcon = L.Icon.extend({
      options: {
         /*shadowUrl: 'leaf-shadow.png',*/
         iconSize:     [32, 32],
      /*   shadowSize:   [50, 64],*/
         iconAnchor:   [22, 94],
        /* shadowAnchor: [4, 62],*/
         popupAnchor:  [-3, -76]
      }
   });

   var  redIcon = new LeafIcon({iconUrl: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEIUlEQVR4nMWXTWxUVRTHf+f2TTsNtmgjSNCYoFSM9oPOu2/SlBLFREcxuNJE3fmx0o2yMCYmRGPcSqILN25MlLgyYAkLEksktQ5vbiakioijGAUkWKIOtLZTOve4mNZM63SGyoj/zWTOvff8f/e98867T1SV6yVrbUpE9gJFEXkxjuMzwfUy7+npaW1vb39XVYcWQt8Cr/ynAAMDA91BEGRUNZNMJodUdbpq+GeApgIMDg52zs/PPwBkgExLS0uHqh4SkQ/a2tqenp+fl3K5/BxQnJmZ+RBArqUGRMREURR67zMLpoPAKWDEGDOSy+Wyqurr5lgtQCqV2igiDwEZEXkQ6FDVoyIy0tLSMnLs2LEfV7WJRgA7duxITk1NbVfVxV32ABeBQwumh7PZ7KVV7aIeQBRFA+VyeYOIbDHGZFT1PqAd+AYYEZER59yXjS7tvwKw1uaBgYW/XlVHRWTEGHMwjuPTzTBcEcBaezdwsmpsFtgG/NlMwyAIprLZ7NklAFEUPamq7wDrmmlWRxdE5KVcLvexpFKpXSLy6XUyXiJVfcwYY/b8H+YAxpg9gar2LosXRGS/qu4E7l1FvhlV/UJEciJyUlXvAiIqdXRDrQWq2hsAbVWxi8VisbdQKJRE5NUwDL8HNjVyFpGjIvJMrSdl69attyYSifdV9eEaS9vMskC2UCiUFug8MNrIXFX3OufuD4LgD2vtm9baCWvtlLX2RBiGbwdB4HO53CMi8kZN+DAMqztRyXu/JZ/P/9Tf378+kUicAm6s438cSDvnrjQCFREThuHnwHA9AIArQBZIs/T21FJYLBZPdHZ2HhSRjjrz5oBdwM1AAZDFgVqv4wSwvYExwKRzLp9Op+/w3n92FfNvd859Za39DthSD2BaREYX3gGddRLmF343UDnd1JUxpgtARHKquiLAtPd+Uz6fnxweHu6YnZ39gRW6o4j8AuC9f43Ko1ZX3vuvgWFVPVsdXwIgIqP5fH4SYGxs7LK19gDw/Ao5ewGcc482Mq+WqvaL/F0C/yjCS8lk8raxsbHL3d3dbWvXrj0NbFwhV4nKYWSziHxCVWHVkjHm2TiOx621k1SKsSYAwCRwANhZx3xRLzjn3oui6HHvfc1uByAic865fVEUPaWq+5aM1QBYjaaNMX1xHJ8eGhrqKpVKO6m6rSKiwGHn3Pl0Or3Be38C6KpOsLwTrlZrvPf7U6nUPePj478FQRCLSJcxxgLrvPfHnXPnrbV3eu8PLDeHa78CiyoBrxtjPorj+MxiMJVKbTTGPAG8BayptVDCMLwArG8CxKIuUjmabwZuaTD3VyMiR5poDpUK33YV5ojIEVMul3cD55oMcTU6Vy6Xd4uq0tfXd1Nra+vLVL5s6rXfZugSkJ2bm9s7MTHx+zV9mjVDfwF4y628AaWdvAAAAABJRU5ErkJggg=='}) ;






<?php


function locator($loc){

$lat= 
(ord(substr($loc, 1, 1))-65) * 10 - 90 +
(ord(substr($loc, 3, 1))-48) +
(ord(substr($loc, 5, 1))-65) / 24 + 1/48;
$lng= 
(ord(substr($loc, 0, 1))-65) * 20 - 180 +
(ord(substr($loc, 2, 1))-48) * 2 +
(ord(substr($loc, 4, 1))-65) / 12 + 1/24;

return $lat .", ".$lng;


}



foreach ($validRows as $spot)
{
  

echo "L.marker([".locator($spot['locator'])."], {icon: redIcon}).bindPopup('"

."Receiver Callsign: <a href='https://www.qrz.com/lookup?tquery=".$spot['dx']."&mode=callsign' target='_blank'>".$spot['dx']."</a><br>"
."Sender Callsign: ".$spot['op']."<br>"
."Frequency: ".$spot['freq']."<br>"
."Mode: ".$spot['mode']."<br>"
."SNR: ".$spot['sNR']."<br>"
."Date Time: ".gmdate("Y-m-d H:i:s", $spot['time'])."').addTo(map);";

//echo  locator($spot['locator']) . "', '" . $spot['dx'] . "', '" . $spot['op'] . "', '" . $spot['freq'] . "', '" . $spot['mode'] . "','" . date('Y-m-d h:i:s', $spot['time']);

}


}
echo "</script>";
?>





<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, 300000);


function myFunction() {
  return "Do not reload the page...";
}

</script>



</body>
</html>
