<?php

use App\Fast;

function dd($data)
{
    die(var_dump($data));
}

function output($message)
{
    echo "\n $message   \n";
}

function outputOption($key, $value)
{
    echo " \n $key: $value  \n";
}

function input()
{
    return trim(fgets(STDIN));
}

function brakeLine()
{
    echo "\n ------------------- \n";
}

function printArr(array $data){

    brakeLine();

    foreach($data as $key =>$value){
      

       
        outputOption($key,$value['name']);
       
    }
    brakeLine();
}