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

            $this->printNav(Repository::get('nav'), FastAction::getActiveFast());

            $action = input();

            //call for action depending on the user input
            $this->navHandler($action, FastAction::getActiveFast());
        }
    }

    protected function exit()
    {
        $this->status = false;
    }

    public function switchOptions()
    {
    }

    protected function navHandler($action, $activeFast = null)
    {
        if (array_key_exists($action, Repository::get('nav'))) {

            $selectedAction = Repository::get('nav')[$action]['action'];

            if ($activeFast) {
            }

            if ($action == 6) {
                $this->$selectedAction();
            } else {
                FastAction::$selectedAction();
            }
        }
    }
    function printnav(array $data, $activeFast = null)
    {

        if ($activeFast) {
            unset($data[1]);
        } else {
            unset($data[3]);
            unset($data[4]);
        }

        brakeLine();

        foreach ($data as $key => $value) {

            outputOption($key, $value['name']);
        }
        brakeLine();
    }
}
