<?php

namespace SimpleFramework;

class Constants
{
    public const componentsDir = "APP_SF_COMPONENTS";
    public const pagesDir = "APP_SF_PAGES";
    public const rootFile = "APP_SF_ROOT";
    public const notFoundFile = "APP_SF_404";
    private const ignoreRegexList = "APP_SF_IGNORE_REGEX";

    private const _componentsDir = "components";
    private const _pagesDir = "pages";
    private const _rootFile = "index.php";
    private const _notFoundFile = null;
    private const _ignoreRegexList = [
        "/^\/\..*$/", // all hidden files are hidden to http requests
        "/^\/vendor$/", // all hidden files are hidden to http requests
    ];

    static function setDefaults()
    {
        $_ENV[Constants::componentsDir] = Constants::_componentsDir;
        $_ENV[Constants::pagesDir] = Constants::_pagesDir;
        $_ENV[Constants::rootFile] = Constants::_rootFile;
        $_ENV[Constants::notFoundFile] = Constants::_notFoundFile;
        $_ENV[Constants::ignoreRegexList] = Constants::_ignoreRegexList;
    }

    /**
     * Returns APP_SF_IGNORE_REGEX combined with more regex to ignore APP_SF_PAGES and APP_SF_COMPONENTS
     *
     * @return string[]
     */
    static function getIgnoreRegexList(): array
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
