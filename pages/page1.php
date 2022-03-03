<?php
// url request = "/page1"

SimpleFramework\Util::includeComponent("head.html");

echo "i am page 1. look at me";

SimpleFramework\Util::includeComponent("test.php");
SimpleFramework\Util::includeComponent("end.html");
