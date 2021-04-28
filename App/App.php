<?php

namespace App;

use App\Core\Repository;

class App
{
    private $status = true;

    public function  run()
    {
        while ($this->status) {
            FastAction::setActiveFast();
            $this->printNav(Repository::get('nav'), FastAction::getActiveFast());
            $selectedOption = input();
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
