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

            $selectedOption = input();

            //call for action depending on the user input
            $this->navHandler($selectedOption, Repository::get('nav'), FastAction::getActiveFast());
        }
    }

    protected function navHandler($selectedOption,array $navActions, $activeFast = null)
    {
        if ($activeFast) {
            
            unset($navActions[1]);
        } else {

            unset($navActions[3]);

            unset($navActions[4]);
        }

        if (array_key_exists($selectedOption, $navActions)) {

            $selectedAction = Repository::get('nav')[$selectedOption]['action'];

         

            if ($selectedOption == 6) {

                $this->$selectedAction();
            } else {

                FastAction::$selectedAction();
            }
        } else {
            output("Option $selectedOption dosent Exist!");
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

    protected function exit()
    {
        $this->status = false;
    }
}
