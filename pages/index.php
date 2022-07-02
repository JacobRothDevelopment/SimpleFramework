<?php
// url request = "/"

use SimpleFramework\Util;

Util::includeComponent("head.php");

echo "i am root";

Util::includeComponent("test.php");
Util::includeComponent("end.html");

$input = (object)[
    "text" => "parameterized input text"
];
Util::requireComponent("showText.php", $input);

?>

<img src="/assets/EXAMPLE.png" alt="">