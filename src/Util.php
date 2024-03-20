<?php

namespace SimpleFramework;

class Util
{
    /**
     * Import a Component into pages or other components
     *
     * @param string $component
     * @param object|null $data
     * @return void
     */
    public static function includeComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDir];
        include($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    /**
     * * Import a Component into pages or other components;
     *
     * @param string $component
     * @param object|null $data
     * @return void
     * @throws Exception if Component doesn't exist
     */
    public static function requireComponent(string $component, object $data = null)
    {
        $cDir = $_ENV[Constants::componentsDir];
        require($_SERVER['DOCUMENT_ROOT'] . "/$cDir/$component");
    }

    /**
     * Call in root index.php to start the process
     *
     * @return void
     */
    public static function loadContent()
    {
        $pDir = $_ENV[Constants::pagesDir];
        $originalRequest = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // pages accessible from url must be .php
        $adjustedRequest = "/$pDir" . $originalRequest . ".php";
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        if ($originalRequest === "/") {
            // if the request if for /, deliver that
            // since "/" does not have a document name, assume they want index
            $rootFile = $_ENV[Constants::rootFile];
            require($rootDir . "/$pDir/$rootFile");
        } elseif (file_exists($rootDir . $adjustedRequest)) {
            // if php page exist, deliver that
            require($rootDir . $adjustedRequest);
        } else {
            // if the page file does not exist,
            //   assume they want an asset file (js, css, etc.)

            // before anything, test if request should be ignored
            foreach (Util::getIgnoreRegexList() as $regex) {
                if (preg_match($regex, $originalRequest) === 1) Util::return404();
            }

            $file = $rootDir . $originalRequest;
            if (is_file($file)) {
                // if file exists, return it and set content-type header
                $contentType = Util::getContentType($file);
                header("Content-Type: $contentType");
                include($rootDir . $originalRequest);
            } else {
                // if the file requested is not found, return 404
                Util::return404();
            }
        }
    }

    /**
     * Display $_SERVER data
     *
     * @return void
     */
    public static function showServer()
    {
        echo "<pre>" . print_r($_SERVER, true) . "</pre>";
    }

    /**
     * * Get mime content type for `Content-Type` header
     * * Uses apache's mime.types by default
     *
     * @param string $file
     * @return string
     */
    private static function getContentType(string $file): string
    {
        // for future reference maybe:
        // http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        // https://docs.w3cub.com/http/basics_of_http/mime_types/complete_list_of_mime_types.html
        // https://www.php.net/manual/en/function.mime-content-type.php
        $fileExt = pathinfo($file, PATHINFO_EXTENSION);

        $type = array_key_exists($fileExt, $_ENV[Constants::mimeTypes])
            ? $_ENV[Constants::mimeTypes][$fileExt]
            : false;

        return $type === false ? "" : $type;
    }

    /**
     * * Sets response code to 404
     * * Includes the default 404 page (if defined)
     * * Calls `exit`, terminating the request
     *
     * @return void
     */
    private static function return404()
    {
        http_response_code(404);
        if ($_ENV[Constants::notFoundFile] !== null) {
            $isRelative = file_exists($_SERVER['DOCUMENT_ROOT'] . $_ENV[Constants::notFoundFile]);

            if ($isRelative) {
                include($_SERVER['DOCUMENT_ROOT'] . $_ENV[Constants::notFoundFile]);
            } else {
                include($_ENV[Constants::notFoundFile]);
            }
        }
        exit;
    }

    /**
     * Returns APP_SF_IGNORE_REGEX combined with more regex to ignore APP_SF_PAGES and APP_SF_COMPONENTS
     *
     * @return string[]
     */
    private static function getIgnoreRegexList(): array
    {
        $pagesDir = $_ENV[Constants::pagesDir];
        $componentsDir = $_ENV[Constants::componentsDir];

        return array_merge(
            $_ENV[Constants::ignoreRegexList],
            [
                "/^\/$pagesDir\/.*$/", // pages files should not be accessed outside of index.php
                "/^\/$componentsDir\/.*$/", // component files should not be accessed outside of index.php
                "/^\/index.php$/", // requests to index.php should 404
            ],
        );
    }
}
