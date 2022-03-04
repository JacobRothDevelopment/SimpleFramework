<?php
// url request = "/page1"
use SimpleFramework\Util;

Util::includeComponent("head.php", (object)[
    "title" => "This is Page1"
]);

echo "i am page 1. look at me";

Util::includeComponent("test.php");
Util::includeComponent("end.html");
