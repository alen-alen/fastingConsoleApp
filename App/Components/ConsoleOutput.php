<?php

namespace App\Components;

class ConsoleOutput
{
    public function write($output): void
    {
        echo $output . PHP_EOL;
    }
    public function writeList(array $outputArray): void
    {
        foreach ($outputArray as $key => $outputOption) {
            echo $key + 1 . '. ' . $outputOption['name'] . PHP_EOL;
        }
    }
    public function writeObjectProperties(array $outputArray): void
    {
        echo "----------------------------------------".PHP_EOL;
        foreach ($outputArray as $key => $value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
        echo "----------------------------------------".PHP_EOL;
    }
}
