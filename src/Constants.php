<?php

namespace SimpleFramework;

class Constants
{
    public const componentsDir = "APP_SF_COMPONENTS";
    public const pagesDir = "APP_SF_PAGES";
    public const rootFile = "APP_SF_ROOT";
    public const notFoundFile = "APP_SF_404";
    public const ignoreRegexList = "APP_SF_IGNORE_REGEX";
    public const mimeTypesPath = "APP_SF_APACHE_MIME_DOT_TYPES";
    public const mimeTypes = "APP_SF_MIME_TYPES_MAP";

    private const _componentsDir = "components";
    private const _pagesDir = "pages";
    private const _rootFile = "index.php";
    private const _notFoundFile = null;
    private const _ignoreRegexList = [
        "/^\/\..*$/", // all hidden files are hidden to http requests
        "/^\/vendor$/", // all hidden files are hidden to http requests
    ];
    private const _mimeTypesPath = "/etc/mime.types";

    static function setDefaults()
    {
        $_ENV[Constants::componentsDir] = Constants::_componentsDir;
        $_ENV[Constants::pagesDir] = Constants::_pagesDir;
        $_ENV[Constants::rootFile] = Constants::_rootFile;
        $_ENV[Constants::notFoundFile] = Constants::_notFoundFile;
        $_ENV[Constants::ignoreRegexList] = Constants::_ignoreRegexList;
        $_ENV[Constants::mimeTypesPath] = Constants::_mimeTypesPath;
        $_ENV[Constants::mimeTypes] = Constants::parseMimeTypes();
    }

    /**
     * * parses file at APP_SF_APACHE_MIME_DOT_TYPES
     * * (string) file extension => (string) mime type
     * * if file does not exists, returns empty array
     *
     * @return array
     */
    private static function parseMimeTypes(): array
    {
        if (!is_file($_ENV[Constants::mimeTypesPath])) return [];

        $dict = array();
        $content = file_get_contents($_ENV[Constants::mimeTypesPath]);
        $e = explode("\n", $content);
        foreach ($e as $line) {
            // ignore if line is commented out
            // or line is empty
            if (strlen($line) <= 0 || $line[0] === '#') continue;
            $type_exts_list = preg_split("/\s+/", $line);
            $mime = $type_exts_list[0];
            for ($i = 1; $i < count($type_exts_list); $i++) {
                $ext = $type_exts_list[$i];
                $dict[$ext] = $mime;
            }
            $dict[""] = "text/plain";
        }
        return $dict;
    }

    /**
     * * Parses mime type file and sets mime type map to 
     * `$_ENV['APP_SF_MIME_TYPES_MAP']`
     * * If file does not exists, the map will be empty
     *
     * @return void
     */
    static function setMimeTypesMap(): void
    {
        $_ENV[Constants::mimeTypes] = Constants::parseMimeTypes();
    }
}
