<?php

namespace Bologer\Plugin;

use Bologer\Config;

/**
 * PluginFactory helps to build plugin objects for given alias name.
 *
 * @package Bologer\Plugin
 */
class PluginFactory
{
    /**
     * @var array<string, LoadablePlugin> List of avaolable plugins.
     */
    private static $plugins = [
        'code' => CodePlugin::class
    ];

    /**
     * Creates an instance of plugin object with provided config.
     * @param string $plugin Plugin slug, such as "code".
     * @param Config $config
     * @return LoadablePlugin
     */
    public static function create(string $plugin, Config $config): LoadablePlugin
    {
        /** @var BasePlugin $class */
        $class = self::$plugins[$plugin];
        return new $class($config);
    }
}
