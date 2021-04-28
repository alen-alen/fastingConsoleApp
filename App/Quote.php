<?php

namespace App;

class Quote
{

    public $quotes = [];

    public function __construct()
    {
        $this->quotes = json_decode(file_get_contents('myQuotes.json'));
    }
    
    public function getOne()
    {
        $quote = $this->quotes[rand(0, count($this->quotes) - 1)];

        return $quote->text;
    }
}
