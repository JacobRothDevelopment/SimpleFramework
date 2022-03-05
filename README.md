# SimpleFramework

SimpleFramework is a simple framework for building out html\php pages

```bash
composer require jacob-roth/simple-framework
```

## So J, what does this do?

Ever want to build a static website **_and_** want to reuse code you made? No? What do you mean no one build static sites anymore? Well, SimpleFramework lets you do this anyway.

- Pretty URLS
  - maps requests to `pages` directory
  - ex: requesting `/page1` tries to deliver `/pages/page1.php`
  - ex: requesting `/creative/page1` tries to deliver `/pages/creative/page1.php`
- Build Pages
  - In the `Pages` directory
- Build Components
  - In the `Components` directory
  - Components can be reused between pages
  - Can take data parameters from `$data` object

## What You Need To Do

1. `composer require jacob-roth/simple-framework`

2. Create `/pages` Directory

3. Create `/components` Directory

4. Copy `.htaccess` into project root directory

5. Create `index.php` in project root directory

6. Add the following to `index.php`

   ```php
   SimpleFramework\Util::loadContent();
   ```

## Using Util

| Util function    | Description                                          |
| ---------------- | ---------------------------------------------------- |
| includeComponent | Import Component                                     |
| requireComponent | Import Component; throws error if file doesn't exist |
| loadContent      | start processing the url request                     |

## ENVs

If needed, you can change some of the defaults in SimpleFramework using `$_ENV`

| $\_ENV name       | Default    | Description                                 |
| ----------------- | ---------- | ------------------------------------------- |
| APP_SF_COMPONENTS | components | Directory where component files are located |
| APP_SF_PAGES      | pages      | Directory where pages are located           |
| APP_SF_ROOT       | index      | Root PHP page name                          |
