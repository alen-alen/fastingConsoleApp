<?php

namespace App\Components;

class ConsoleInput
{
    public function read(): string
    {
        return trim(fgets(STDIN));
    }
}
