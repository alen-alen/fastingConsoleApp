<?php

namespace App;

class App
{
    private $status = true;

    public function  run()
    {
        FastAction::setActiveFast();

        while ($this->status) {

            outputOption(1, 'Start New Fast');

            outputOption(2, 'Check Status');

            outputOption(3, 'End the active fast');

            // outputOption(4, 'Update an Active Fast');

            outputOption(5, 'Exit');

            switch (input()) {
                case 1:

                    output(FastAction::startNew());

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

                // case 4:
                //     FastAction::editFast();

                //     brakeLine();

                //     break;

                case 5:

                    brakeLine();

                    $this->exit();

                    break;

                default:

                    echo "incorect input \n";

                    brakeLine();
            }
        }
    }

    public function exit()
    {
        $this->status = false;
    }
}
