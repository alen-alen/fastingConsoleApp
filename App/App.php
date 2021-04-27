<?php

namespace App;

use App\Core\Repository;

class App
{
    private $status = true;

    public function  run()
    {

        //kako da se uprosti ova ???
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

    public function switchOptions()
    {
    }

    protected function actionHandler($action)
    {
        if (array_key_exists($action, Repository::get('nav'))) {

            $selectedAction = Repository::get('nav')[$action]['action'];

            if ($action == 6) {
                $this->$selectedAction();
            }else{
                FastAction::$selectedAction();
            }
            
        }
    }
}
