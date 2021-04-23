<?php


$date = new DateTime();
$date->setDate(date("Y"), 02, 03);
$date->setTime(15, 35, date("s"));
echo $date->format('M d,H:i:s');


var_dump($date);