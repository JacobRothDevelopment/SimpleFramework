<?php

require_once __DIR__ . "/src/Util.php";
require_once __DIR__ . "/src/Constants.php";


$_ENV[SimpleFramework\Constants::notFoundFile] = __DIR__ . "/pages/404.php";
$_ENV[SimpleFramework\Constants::mimeTypesPath] = "C:\\xampp82\\apache\\conf\\mime.types";
SimpleFramework\Constants::setDefaults();

SimpleFramework\Util::loadContent();
