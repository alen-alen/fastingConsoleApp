<?php

namespace App;


use App\Components\ConsoleInput;
use App\Components\ConsoleOutput;

use App\TrackerComponents\MethodHandler;
use App\TrackerComponents\Printer;


class App
{
    public function  boot(): Tracker
    {
        $printer = new Printer(new ConsoleOutput());

        return new Tracker(new ConsoleInput(), $printer, new MethodHandler());
    }
}
