# SimpleFramework

SimpleFramework is a simple framework for building out php pages

```bash
composer require jacob-roth/simple-framework
```

## So J, what does this do?

Ever want to build a static website **_and_** want to reuse code you made? No? What do you mean no one builds static sites anymore? Well, SimpleFramework lets you do this anyway.

What's that? Other packages do this better? That's probably true. You should use them, then.

What SimpleFramework does:

- URL Routing
  - maps requests to `pages` directory
    - ex: requesting `/page1` delivers `/pages/page1.php`
    - ex: requesting `/creative/page1` delivers `/pages/creative/page1.php`
  - still works for assets
    - ex: requesting `/assets/styles.css` delivers `/assets/styles.css`
- Build Pages
  - PHP pages in the `pages` directory
  - Use Components
- Build Components
  - PHP or HTML files in the `components` directory
  - Components can be reused between pages
  - Can pass parameters through `$data` object to and between components

## What You Need To Do

1. `composer require jacob-roth/simple-framework`

2. Create `/pages` and `/components` directories in project root

3. Add the following to `.htaccess` into project root directory

   ```apache
   RewriteEngine On
   RewriteRule ^(.*)$ index.php [NC,L,QSA]
   ```

4. Create `index.php` in project root directory

5. Add the following to `index.php`

   ```php
   SimpleFramework\Constants::setDefaults();
   SimpleFramework\Util::loadContent();
   ```

## Using Util

| Util function    | Description                                                |
| ---------------- | ---------------------------------------------------------- |
| includeComponent | Import Component                                           |
| requireComponent | Import Component<br/>Throws error if file doesn't exist    |
| loadContent      | Start processing the url request                           |
| loadResource     | Load only given resource file (ie stylesheet, image, etc.) |

## ENVs

If needed, you can change some of the defaults in SimpleFramework using `$_ENV`

| $\_ENV name                  | Default                         | Description                                                                    |
| ---------------------------- | ------------------------------- | ------------------------------------------------------------------------------ |
| APP_SF_COMPONENTS            | `components`                    | Directory where component files are located                                    |
| APP_SF_PAGES                 | `pages`                         | Directory where pages are located                                              |
| APP_SF_ROOT                  | `index.php`                     | Root PHP page name                                                             |
| APP_SF_404                   | `null`                          | The page delivered when url doesn't map to file                                |
| APP_SF_IGNORE_REGEX          | `["/^\/\..*$/","/^\/vendor$/"]` | If any requests match any of the regular expressions, automatically return 404 |
| APP_SF_APACHE_MIME_DOT_TYPES | `/etc/mime.types`               | The file path for apache mime types                                            |
| APP_SF_MIME_TYPES_MAP        | `null`                          | Map of file extensions to content types                                        |

You can set these ENVs like this:

```php
$_ENV[SimpleFramework\Constants::notFoundFile] = __DIR__ . "/pages/404.php";
```

This must be done after calling `Constants::setDefaults()`

# Limitations

- If you choose to change the ENV variable `APP_SF_APACHE_MIME_DOT_TYPES`, you must run the following to properly create the type mapping

```php
SimpleFramework\Constants::setMimeTypesMap();
```
