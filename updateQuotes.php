<?php

$quotes = file_get_contents("https://type.fit/api/quotes");

file_put_contents('myQuotes.json',$quotes);

