<?php

$userInput= trim(fgets(STDIN));


$startDate=strtotime($userInput);


echo  date("M d,H:i",$startDate) . "\n";


// $date = new DateTime();

$endDate = date("M d,H:i", strtotime('+3 hours', $startDate));

echo $endDate;
// $date->setDate(date("Y"), 02, 03);
// $date->setTime(15, 35, date("s"));
// echo $date->format('M d,H:i:s');


