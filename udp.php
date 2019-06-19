<?php
//PHP Udp Packet Sender
//analysis tool https://pskreporter.info/cgi-bin/psk-analysis.pl

$server_ip   = "report.pskreporter.info";
$server_port = 14739;
$beat_period = 5;
$hextime = dechex(time());
$message     = hex2bin("000A00AC".$hextime."0000000100000000");
$message    .= hex2bin("000300249992000300008002FFFF0000768F8004FFFF0000768F8008FFFF0000768F0000");
$message    .= hex2bin("0002002C999300038001FFFF0000768F800500040000768F800AFFFF0000768F800B00010000768F00960004");
//$message    .= hex2bin("99920020044E31445106464E3432686E0D 486F6D65627265772076352E36 0000");
$message      .= hex2bin("99920020044E31445106464E3432686E0D5068705265706F7274657256310000");

						
$message    .= hex2bin("9993002C044E31445100D6B3270350534C0147953254");
$message    .= hex2bin("064B42314D425800D6B4CB0350534C0147953268");
$message    .= hex2bin("0000");

print "Sending heartbeat to IP $server_ip, port $server_port";
print "press Ctrl-C to stopn";
if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
  while (1) {
    socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
    print "Time: " . date("%r") . "n";
    sleep($beat_period);
  }
} else {
  print("can't create socketn");
}
?>
