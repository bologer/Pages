#!/usr/bin/env php
<?php

$fileToRequire = null;
foreach (array(__DIR__ . '/../../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        $fileToRequire = $file;
    }
}

if ($fileToRequire === null) {
    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );
    die(1);
}

require $fileToRequire;

use Garden\Cli\Cli;
use Bologer\Pages;
use Bologer\Config;

$cli = new Cli();

$cli->description('Pages - easy way to generate documentation.')
    ->opt('docs-dir', 'Absolute directory to documentation folder to be processed.', true, 'string')
    ->opt('dist-dir', 'Absolute directory where to put generated files.', true, 'string')
    ->opt('code-highlight-languages', 'CSV list of languages available for highlight, e.g. html,php,javascript. See https://highlightjs.org/usage/ for details.', false, 'string')
    ->opt('plugins', 'CSV list of plugins to be loaded. Available options: code.', false, 'string');

// Parse and return cli args.
$args = $cli->parse($argv, true);

$config = new Config();
$config->docsFolder = $args->getOpt('docs-dir');
$config->distFolder = $args->getOpt('dist-dir');

$languages = $args->getOpt('code-highlight-languages');

if (!empty($languages)) {
    $config->codeHighlightLanguages = explode(',', $languages);
}

$plugins = $args->getOpt('plugins');
if (!empty($plugins)) {
    $config->plugins = explode(',', $plugins);
}

$pages = new Pages($config);
$pages->build();