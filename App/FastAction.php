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
            $fast->setTimeElapsed();
            $fast->status = true;
            if ($fast->saveToJson()) {
                self::$activeFast = $fast;
                output('Succesfuly created new fast');
            } else {
                output('Something went wrong');
            }
        } else {
            output('Alread have an active fast');

            return self::status();
        }
    }
    ///////////////////////////////////////////////////////////////// OUTPUT THE ACTIVE FAST
    public static function status()
    {
        $fast = self::$activeFast;
        if ($fast == true) {
            self::printFast($fast);
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

        if (file_put_contents('results.json', $newJsonData)) {

            output('Active Fast Stoped!');
        }
    }

    public static function editFast()
    {
        if (self::$activeFast) {
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
            if (file_put_contents('results.json', $newJsonData)) {
                output('Edited Active Fast');
            }
        } else {
            output('There is no active fast!');
        }
    }
//////////////////////////////////////////////////////////////////////SHWO ALL FASTS
    public static function listAll()
    {
        foreach (json_decode(file_get_contents('results.json')) as $fast) {
            if ($fast->status == false) {
                self::printFast($fast);
            }
        }
        self::$activeFast ? self::printFast(self::$activeFast) : '';
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
                    self::$activeFast;
                    return ;
                }
            }
        }
    }
//////////////////////////////////////////////////////////////////PRINT A FAST
    protected static function printFast($fast)
    {
        brakeLine();

        $quote=new Quote();
        output($quote->getOne());
        outputOption('Status', $fast->status ? 'Active' : 'Inactive');
        outputOption('Fast type', $fast->type . ' hour Fast');
        outputOption('Start date', $fast->startDate);
        outputOption('End date', $fast->endDate);
        outputOption('Time Elapsed', $fast->timeElapsed);

        brakeLine();
    }

    ///////////////////return the active fast
    public static function getActiveFast()
    {
        if (self::$activeFast) {
            return self::$activeFast;
        }
        return false;
    }
}
