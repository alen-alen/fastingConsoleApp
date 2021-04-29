<?php

namespace App\Database;

use App\FastComponents\Fast;

class Database
{

    public function getData($filePath): array
    {
        $data = file_get_contents($filePath);

        return (array) json_decode($data);
    }

    public function saveData($filePath, Fast $fast): void
    {
        $this->createDbFile($filePath);

        $fileData = (array) $this->getData($filePath);

        array_push($fileData, $fast);

        $newData = json_encode($fileData);

        file_put_contents($filePath, $newData);
    }

    private function createDbFile($filePath): void
    {
        if (!file_exists($filePath)) {
            $myfile = fopen($filePath, "w");
            fclose($myfile);
        }
    }
}
