<?php
require __DIR__.'/vendor/autoload.php';

use App\Command\TvProgrammes;
use Symfony\Component\Console\Application;

define("SUCCESS", 0);
define("FAILURE", 1);

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$application = new Application();

$application->add(new TvProgrammes());

$application->run();