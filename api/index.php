<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';
require '../config/db.php';
require 'routes/school.php';
require 'routes/subject.php';
require 'routes/student.php';
require 'routes/user.php';
require 'routes/class.php';
require 'routes/class_room.php';

$app->run();