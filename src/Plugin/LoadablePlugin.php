<?php


namespace Bologer\Plugin;


use Bologer\Layout\Layout;

/**
 * PluginLoader shares common structure for pluging to load.
 * @package Bologer\Plugin
 */
interface LoadablePlugin
{
    /**
     * Loads the plugin into given layout.
     * @param Layout $layout
     * @return mixed
     */
    public function load(Layout $layout);
}