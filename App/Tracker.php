<?php

namespace App;


use App\Database\Database;
use App\FastComponents\Fast;
use App\Components\ConsoleInput;
use App\TrackerComponents\Printer;
use App\TrackerComponents\MethodHandler;

class Tracker extends Database
{
    protected ConsoleInput $input;

    protected Printer $printer;

    protected MethodHandler $handler;
    /**
     * @var Fast $activeFast
     */
    protected $activeFast;


    private bool $status = false;

    protected array $allFasts;

    protected $navigationOptions = [

        [
            'name' => 'Start Fast', 'action' => 'fastCreate', 'flag' => 'ACTIVE'
        ],
        [
            'name' => 'Status', 'action' => 'fastStatus', 'flag' => 'ACTIVE'
        ],
        [
            'name' => 'Stop Fast', 'action' => 'fastStop', 'flag' => 'ACTIVE'
        ],
        [
            'name' => 'Edit Fast', 'action' => 'fastEdit', 'flag' => 'ACTIVE'
        ],
        [
            'name' => 'Show All Fasts', 'action' => 'fastList', 'flag' => 'ACTIVE'
        ],
        [
            'name' => 'Exit', 'action' => 'exit', 'flag' => 'ACTIVE'
        ]
    ];

    public function __construct(ConsoleInput $input, Printer $printer, MethodHandler $handler)
    {
        $this->input = $input;
        $this->printer = $printer;
        $this->handler = $handler;
        $this->status = true;

        $this->loadFasts();
        $this->run();
    }

    public function run()
    {
        while ($this->status) {
            $data = $this->getData('data.json');

            $this->setActiveFast($data);

            $this->printer->printNav($this->navigationOptions, $this->activeFast->status);

            $usrInput = (int) $this->input->read();

            $action = $this->handler->run(
                $this->navigationOptions,
                $usrInput,
                $this->activeFast->status,
                "action"
            );
            $this->$action();
        }
    }

    public function fastCreate()
    {
        $newFast = new Fast('Active');

        $userStartDate = $this->askForStartDate();
        $newFast->setStartDate($userStartDate);

        $userType = $this->askForType([['name' => '13 hour fast'], ['name' => '15 hour fast'], ['name' => '18 hour fast']]);
        $newFast->setType($userType);
        $newFast->setEndDate();
        $newFast->setTimeElapsed();

        $this->saveData('data.json', $newFast);
    }

    public function fastStatus(): void
    {
        $this->printer->printStatus((object)$this->activeFast);
    }

    public function askForStartDate(): string
    {
        $this->printer->printMsg('Enter Start Date in format:*****');

        return (string) $this->input->read();
    }

    public function askForType(array $types): string
    {
        $this->printer->printFastTypes($types);

        $input = $this->input->read();

        return (int) $types[$input]['name'];
    }

    public function fastStop()
    {
        $allFasts = $this->getData('data.json');
    }
    public function loadFasts()
    {
        $this->allFasts = $this->getData('data.json');
    }

    public function fastEdit()
    {
        $this->printer->printMsg('Fast Edit');
    }

    public function fastList(): void
    {
        $this->printer->printAllFasts($this->getData('data.json'));
    }

    public function setActiveFast($allFasts)
    {
        // die(var_dump($this->activeFast));

        if (!$this->activeFast) {
            $activeFast = array_filter($allFasts, function ($fast) {

                return $fast->status == 'Active';
            });
            $activeFast = new Fast($activeFast[0]->status, $activeFast[0]->startDate, $activeFast[0]->type, $activeFast[0]->endDate);

            $activeFast->setTimeElapsed();

            $this->activeFast = $activeFast;
        }
    }
    public function checkActiveFast(): bool
    {
        if (!$this->activeFast) {
            return true;
        }
        return false;
    }

    public function tryAgain()
    {
        $this->printer->printMsg('Invalid Input!');
        $this->run();
    }

    public function exit()
    {
        $this->status = false;
    }
}
