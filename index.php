<?php

require_once __DIR__ . "/src/Util.php";
require_once __DIR__ . "/src/Constants.php";

SimpleFramework\Constants::setDefaults();

$_ENV[SimpleFramework\Constants::notFoundFile] = __DIR__ . "/pages/404.php";

SimpleFramework\Util::loadContent();
