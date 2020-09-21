# Pages 

Pages is a lightweight PHP utility to build documentation. 

You may use CLI utility or require library files in your project.

Run it in console: 
```
php vendor/bin/parser.php \
    --docs-dir=/path/to/docs
    --dist-dir=/path/to/dist 
    --code-highlight-languages=php,javascript
    --plugins=code
```

Or put it directly in your project:
```php
use Bologer\Pages;
use Bologer\Config;

$config = new Config();
$config->docsFolder = __DIR__ . '/docs';
$config->distFolder = __DIR__ . '/dist';
$config->codeHighlightLanguages = ['html', 'php', 'javascript'];
$config->plugin = ['code'];
$pages = new Pages($config);
$pages->build();
```

## Installing Pages
The recommended way to install Pages is through Composer.

```
composer require bologer/pages
```

### Get Started

You can find documentation here - https://bologer.github.io/pages/docs/get-started.html. 

By the way, the documentation on that link is built by Pages.
