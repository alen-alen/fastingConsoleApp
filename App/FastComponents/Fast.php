<?php

namespace App\FastComponents;

use DateTime;

class Fast
{
    public string $status = 'Inactive';

    public string $startDate;

    public int $type;

    public string $endDate;

    public string $timeElapsed;

    public function __construct(string $status='Inactive',string $startDate='',int $type=0,string $endDate='',string $timeElapsed='')
    {
        $this->status=$status;
        $this->startDate=$startDate;
        $this->type=$type;
        $this->endDate=$endDate;
        $this->timeElapsed=$timeElapsed;
      
    }

    public function setStartDate(string $userInput): void
    {
        $this->startDate = date("M d,H:i", strtotime($userInput));
    }

    public function setType(string $inputType): void
    {
        $this->type = $inputType;
    }

    public function setEndDate(): void
    {
        $this->endDate = date("M d,H:i", strtotime("+$this->type hours", strtotime($this->startDate)));
    }
    public function setTimeElapsed(): void
    {
        $startDate = new DateTime($this->startDate);

        $currentDate = new DateTime();

        $interval = $startDate->diff($currentDate);

        $timeElapsed = $interval->format('%H:%I:%S');

        $this->timeElapsed = $timeElapsed;
    }
}
