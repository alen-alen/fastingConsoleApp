<?php

namespace App\TrackerComponents;

use App\Components\ConsoleOutput;

class Printer
{
    public ConsoleOutput $output;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
    }

    public function printNav($navOptions, $fastStatus): void
    {
        $filter = new MethodHandler();

        $filteredNav = $filter->filterOptions($navOptions, $fastStatus);

        $this->output->writeList($filteredNav);
    }

    public function printFastTypes($types): void
    {
        $this->output->writeList($types);
    }

    public function printStatus(object $fast): void
    {
        $fastProperties = get_object_vars($fast);

        $this->output->writeObjectProperties($fastProperties);
    }

    public function printAllFasts($allFasts): void
    {
        foreach ($allFasts as $key => $fast)
            $this->printStatus($fast);
    }

    public function printMsg($output)
    {
        $this->output->write($output);
    }
}
