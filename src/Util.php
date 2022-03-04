<?php

namespace SimpleFramework;

class Util
{
    public static function includeComponent(string $component, object $data = null)
    {
        include($_SERVER['DOCUMENT_ROOT'] . "/components/$component");
    }

    public static function requireComponent(string $component, object $data = null)
    {
        require($_SERVER['DOCUMENT_ROOT'] . "/components/$component");
    }

    public static function loadContent()
    {
        $originalRequest = $_SERVER['REQUEST_URI'];
        $adjustedRequest = "/pages" . $originalRequest . ".php";
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        if ($originalRequest === "/") {
            require($rootDir . "/pages/index.php");
        } elseif (file_exists($rootDir . $adjustedRequest)) {
            require($rootDir . $adjustedRequest);
        } else {
            if (file_exists($originalRequest)) {
                include($rootDir . $originalRequest);
            } else {
                http_response_code(404);
            }
        }
    }

    public static function showServer()
    {
        echo "<pre>" . print_r($_SERVER, true) . "</pre>";
    }
}
