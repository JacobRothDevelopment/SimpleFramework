<?php

require_once __DIR__ . "/src/Util.php";
require_once __DIR__ . "/src/Constants.php";

SimpleFramework\Constants::setDefaults();

$_ENV[SimpleFramework\Constants::notFoundFile] = __DIR__ . "/pages/404.php";
$_ENV[SimpleFramework\Constants::mimeTypesPath] = "C:\\xampp82\\apache\\conf\\mime.types";

SimpleFramework\Constants::setMimeTypesMap();
SimpleFramework\Util::loadContent();
