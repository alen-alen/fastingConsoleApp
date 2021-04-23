<?php

namespace App;

use DateTime;
use Carbon\Carbon;
use Carbon\Traits\Date;

class Fast
{
    public $status = false,
        $startDate,
        $endDate,
        $elapsedTime,
        $type,
        $types = ['13', '16', '18']; // this types will not be here

    public function __construct()
    {
        $this->status = true;
    }

    public function StartNewFast()
    {
        $this->setStartDate();

        $this->setType();

        $this->setEndDate();

        $newFast = [
            'id' => rand(0, 10),
            'status' => $this->status,
            '$startDate' => $this->startDate,
            "endDate" => $this->endDate,
            'elapsedTime' => $this->setTimeElapsed(),
            'type' => $this->type,
        ];
        $oldFasts = file_get_contents('fasts.json');
        $decodedFasts = (array)json_decode($oldFasts);

        $decodedFasts[] = $newFast;
        $jsonData = json_encode($decodedFasts);
        file_put_contents('fasts.json', $jsonData);
    }
    public function test()
    {
        $oldFasts = file_get_contents('fasts.json');
        $decodedFasts = json_decode($oldFasts);
        dd($decodedFasts->fasts);
    }
    public function setStartDate()
    {
        echo 'Enter your starting date' . "\n";


        echo 'Enter your starting month (the number of the month )' . "\n";
        //    temp validations
        $month = trim(fgets(STDIN));
        $month = $month <= 12 ? $month : die('incorect month');


        echo 'Enter your starting day (number of  the day in the month ):' . "\n";
        $day = trim(fgets(STDIN));
        $day = $day <= 31 ? $day : die('incorect day');
        echo 'Enter your starting hour :' . "\n";
        $hour = trim(fgets(STDIN));
        $hour = $hour < 24 ? $hour : die('wrong hour');
        echo 'Enter your starting minutes :' . "\n";
        $minutes = trim(fgets(STDIN));
        $minutes = $minutes < 60 ? $minutes : die('minutes wrong');
        $date = new DateTime();
        $date->setDate(date("Y"), $month, $day);
        $date->setTime($hour, $minutes, date("s"));




        $this->startDate = $date;
    }
    public function setType()
    {
        echo "Choose your type: \n";
        foreach ($this->types as $type) {
            echo "$type \n";
        }
        $userTypeInput = trim(fgets(STDIN));

        // i will need to create a method to validate the inputs
        //    and a method to activate actions
        if (array_key_exists($userTypeInput, $this->types)) {
            $this->type = $this->types[$userTypeInput];
            return;
        } else {
            echo "wrong Input \n";
            $this->setType();
        }

        // i will need to create a method to validate the inputs
        $this->type = $userTypeInput;
    }
    public function setEndDate()
    {
        $fastType = $this->type;
        $startDateObj = $this->startDate;
        $endDate = clone $startDateObj;

        $this->endDate =  $endDate->modify("+$fastType hour");
    }

    public function setTimeElapsed()
    {
        $currentDate = new DateTime();
        $diff = $this->startDate->diff($currentDate);

        $this->elapsedTime = $diff->format(("%H:%I:%S"));
    }
    public function stop()
    {
        $this->status = false;
    }
    public function checkStatus()
    {
        $this->printFast();
    }
    public function printFast()
    {
        var_dump($this);
    }
    public function save()
    {

        $inp = file_get_contents('fasts.json');
        $tempArray = json_decode($inp);
        array_push($tempArray,);
        $jsonData = json_encode($tempArray);
        file_put_contents('results.json', $jsonData);
    }
}
