<?php

require "bootstrap.php";
require "worker.php";

$urls = [
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
    'https://api.github.com',
    'https://api.google.com',
    'https://api.ipify.org?format=json',
    'https://www.boredapi.com/api/activity',
    'https://official-joke-api.appspot.com/random_joke',
];


for ($i = 0; $i < 10; $i++) {
    $index = array_rand($urls);

    send(['url' => $urls[$index]]);

    unset($index);
}
