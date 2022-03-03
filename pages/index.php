<?php
// url request = "/"

SimpleFramework\Util::includeComponent("head.html");

echo "i am root";

SimpleFramework\Util::includeComponent("test.php");
SimpleFramework\Util::includeComponent("end.html");
