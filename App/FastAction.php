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

            $currentTime = date('M d,H:i', strtotime('-1 hours'));

            $timeDifference = (strtotime($currentTime) - strtotime($fast->startDate)) - strtotime('-1 hour');

            outputOption('Status', $fast->status);

            outputOption('Fast type', $fast->type);

            outputOption('Start date', $fast->startDate);

            outputOption('End date', $fast->endDate);

            outputOption($timeDifference > 0 ? 'Time until start' : 'Time elapsed', date('h:i:s', $timeDifference));
        } else {

            output('no active fast');
        }
    }

    public static function stopFast()
    {

        $existingFasts = json_decode(file_get_contents('results.json'));

        $existingFasts = array_filter($existingFasts, function ($fast) {

            if ($fast->status == true) {

                self::$activeFast = null;

                $fast->status = false;
            }
        });

        $newJsonData = json_encode($existingFasts);

        if (!file_put_contents('results.json', $newJsonData)) {

            return 'something went wrong oops!';
        }
        return "Active Fast stoped at: " . date('M d,H:i:s');
    }

    // public static function editFast()
    // {

    //     $existingFasts = json_decode(file_get_contents('results.json'));

    //     $existingFasts = array_filter($existingFasts, function ($fast) {

    //         if ($fast->status == true) {

    //             $fast->setStartDate();
    //         }
    //     });

    //     $newJsonData = json_encode($existingFasts);

    //     if (!file_put_contents('results.json', $newJsonData)) {

    //         return 'something went wrong oops!';
    //     }
    //     return "Active Fast stoped at: " . date('M d,H:i:s');
    // }


    public static function setActiveFast()
    {

        if (!self::$activeFast) {

            foreach (json_decode(file_get_contents('results.json')) as $fast) {

                if ($fast->status == true) {

                    self::$activeFast = $fast;
                }
            }
        }
    }
}
