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
            foreach (Constants::getIgnoreRegexList() as $regex) {
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
     * Get mime content type for `Content-Type` header
     *
     * @param string $file
     * @return string
     */
    private static function getContentType(string $file): string
    {
        // for future reference maybe:
        // http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        // https://docs.w3cub.com/http/basics_of_http/mime_types/complete_list_of_mime_types.html
        $type = mime_content_type($file);

        return $type === false ? "" : $type;
    }

    /**
     * * Sets response code to 404 <br></br>
     * * Includes the default 404 page (if defined)
     * * Calls `exit`, terminating the request
     *
     * @return void
     */
    private static function return404()
    {
        http_response_code(404);
        if ($_ENV[Constants::notFoundFile] !== null) {
            include($_ENV[Constants::notFoundFile]);
        }
        exit;
    }
}
