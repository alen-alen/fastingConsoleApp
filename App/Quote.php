<?php

namespace App;

class Quote
{

    public $quotes = [];

    public function __construct()
    {
        $this->quotes = $this->updateQuotes();
    }

    protected function updateQuotes()
    {
        return json_decode(file_get_contents("https://type.fit/api/quotes"));
    }
    public function getOne()
    {
        $quote = $this->quotes[rand(0, count($this->quotes) - 1)];

        return $quote->text;
    }
}
