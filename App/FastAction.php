<?php

namespace App;

class FastAction
{
    private static $activeFast;

    public static function startNew()
    {

        if (self::$activeFast == false) {

            $fast = new Fast();

            $fast->setStartDate();

            $fast->setType();

            $fast->setEndDate();

            $fast->status = true;

            if ($fast->saveToJson()) {

                self::$activeFast = $fast;

                return 'Succesfuly created new fast';
            } else {

                return 'Something went wrong';
            }
        } else {

            output('Alread have an active fast');

            return self::status();
        }
    }

    public static function status()
    {
        $fast = self::$activeFast;

        if ($fast == true) {

            //make a function that counts the hours passed from start date to current time or from current time to start date

            $currentTime = date('M d,H:i', strtotime('-1 hours'));

            $timeDifference = (strtotime($currentTime) - strtotime($fast->startDate)) - strtotime('-1 hour');

            outputOption('Status', $fast->status?'Active':'Inactive');

            outputOption('Fast type', $fast->type);

            outputOption('Start date', $fast->startDate);

            outputOption('End date', $fast->endDate);

            outputOption($timeDifference < 0 ? 'Time until start' : 'Time elapsed', date('h:i:s', $timeDifference));
        } else {

            output('no active fast');
        }
    }

    public static function stopFast()
    {
        $existingFasts = json_decode(file_get_contents('results.json'));

        array_filter($existingFasts, function ($fast) {

            if ($fast->status == true) {

                self::$activeFast = null;

                $fast->status = false;
            }
        });

        $newJsonData = json_encode($existingFasts);

        file_put_contents('results.json', $newJsonData);
    }

    public static function editFast()
    {

        $existingFasts = (array)json_decode(file_get_contents('results.json'));

        array_filter($existingFasts, function ($fast) {

            if ($fast->status == true) {

                self::$activeFast->setStartDate();

                self::$activeFast->setType();

                self::$activeFast->setEndDate();

                $fast = self::$activeFast;
            }
        });

        $newJsonData = json_encode($existingFasts);

        file_put_contents('results.json', $newJsonData);
    }

    public static function listAll()
    {
        foreach (json_decode(file_get_contents('results.json')) as $fast) {

            $currentTime = date('M d,H:i', strtotime('-1 hours'));

            $timeDifference = (strtotime($currentTime) - strtotime($fast->startDate)) - strtotime('-1 hour');
            brakeLine();
            outputOption('Status', $fast->status?'Active':'Inactive');

            outputOption('Fast type', $fast->type);

            outputOption('Start date', $fast->startDate);

            outputOption('End date', $fast->endDate);

            outputOption($timeDifference < 0 ? 'Time until start' : 'Time elapsed', date('h:i:s', $timeDifference));
            brakeLine();
        }
    }

    public static function setActiveFast()
    {
        if (!self::$activeFast) {

            foreach (json_decode(file_get_contents('results.json')) as $fast) {

                if ($fast->status == true) {

                    $tmpFast = new Fast();

                    $tmpFast->status = $fast->status;

                    $tmpFast->startDate = $fast->startDate;

                    $tmpFast->endDate = $fast->endDate;

                    $tmpFast->type = $fast->type;

                    self::$activeFast = $tmpFast;

                    return;
                }
            }
        }
    }
}
