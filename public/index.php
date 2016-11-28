<?php
session_start();
require_once __DIR__."/../app/start.php";
$app = new app();
$app->run();