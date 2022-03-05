<?php

namespace SimpleFramework;

class Util
{
    /** Import a Component into pages or other components */
    public static function includeComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDirEnv] ?? Constants::componentsDir;
        include($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    /** Import a Component into pages or other components;
     * throws error if Component doesn't exist */
    public static function requireComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDirEnv] ?? Constants::componentsDir;
        require($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    /** Call in root index.php to start the process */
    public static function loadContent()
    {
        $pDir = $_ENV[Constants::pagesDirEnv] ?? Constants::pagesDir;
        $originalRequest = $_SERVER['REQUEST_URI'];
        // pages accessible from url must be .php
        $adjustedRequest = "/$pDir" . $originalRequest . ".php";
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        if ($originalRequest === "/") {
            // because / does not have a document name, assume they want index
            $rootFile = $_ENV[Constants::rootFileEnv] ??
                Constants::rootFile . ".php";
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

    /** Display $_SERVER data */
    public static function showServer()
    {
        echo "<pre>" . print_r($_SERVER, true) . "</pre>";
    }
}
