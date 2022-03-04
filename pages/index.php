<?php
// url request = "/"

use SimpleFramework\Util;

Util::includeComponent("head.html");

echo "i am root";

Util::includeComponent("test.php");
Util::includeComponent("end.html");

$data = (object)[
    "text" => "parameterized input text"
];
Util::requireComponent("showText.php", $data);
