<?php

namespace App;

use App\Core\Repository;

class App
{
    private $status = true;

    public function  run()
    {

        while ($this->status) {

            //Check if there is an active fast in the json file and set it  as a property
            FastAction::setActiveFast();

            ///print the navbar
            printArr(Repository::get('nav'));

            $action = input();

            //call for action depending on the user input
            $this->actionHandler($action);
        }
    }

    protected function exit()
    {
        $this->status = false;
    }

    protected function actionHandler($action)
    {
        switch ($action) {
            case 1:

                FastAction::startNew();

                brakeLine();

                break;
            case 2:

                FastAction::status();

                brakeLine();

                break;
            case 3:
                FastAction::stopFast();

                brakeLine();

                break;

            case 4:
                FastAction::editFast();

                brakeLine();

                break;
            case 5:

                FastAction::listAll();

                break;

            case 6:

                brakeLine();

                $this->exit();

                break;

            default:

                echo "incorect input \n";

                brakeLine();
        }
    }
}
