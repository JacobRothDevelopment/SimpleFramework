<?php

namespace SimpleFramework;

class Util
{
    public static function includeComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDirEnv] ?? Constants::componentsDir;
        include($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    public static function requireComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDirEnv] ?? Constants::componentsDir;
        require($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    public static function loadContent()
    {
        $pDir = $_ENV[Constants::pagesDirEnv] ?? Constants::pagesDir;
        $originalRequest = $_SERVER['REQUEST_URI'];
        $adjustedRequest = "/$pDir" . $originalRequest . ".php";
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        if ($originalRequest === "/") {
            $rootFile = $_ENV[Constants::rootFileEnv] ?? Constants::rootFile;
            require($rootDir . "/$pDir/$rootFile");
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
