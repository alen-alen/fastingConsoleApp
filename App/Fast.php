<?php

namespace App;

class Fast
{

    public $status = false;

    public $startDate;

    public $endDate;

    public $type;

    public $types = ['13', '16', '18'];

    public function setStartDate()
    {
        output("Enter your starting date MM/dd,HH:ii (July 22,17:30)");

        $userDateInput = input();

        if ($userDateInput) {

            $this->startDate = date("M d,H:i", strtotime($userDateInput));

            return;
        }
        echo " \n Invalid Format \n";

        $this->setStartDate();
    }

    public function setType()
    {
        echo "Choose your type: \n";

        foreach ($this->types as $type) {

            echo "$type \n";
        }
        $userTypeInput = trim(fgets(STDIN));

        if (array_key_exists($userTypeInput, $this->types)) {

            $this->type = $this->types[$userTypeInput];

            return;
        } else {

            echo "wrong Input \n";

            $this->setType();
        }

        $this->type = $userTypeInput;
    }

    public function setEndDate()
    {

        $this->endDate = date("M d,H:i", strtotime("+$this->type hours", strtotime($this->startDate)));
    }

    public function saveToJson()
    {
        $data = file_get_contents('results.json');

        $existingFasts = (array)json_decode($data);

        // $newFast = [
        //     'status' => $this->status,
        //     'type' => $this->type . ' hours',
        //     'startDate' => $this->startDate,
        //     'endDate' => $this->endDate,
        // ];

        array_push($existingFasts, $this);

        $newJsonData = json_encode($existingFasts);

        if (file_put_contents('results.json', $newJsonData)) {

            return true;
        }
        return false;
    }
}
