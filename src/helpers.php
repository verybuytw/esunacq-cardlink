<?php

use Illuminate\Config\Repository;

if (!function_exists('config')) {
    function config($path = null, $default = null)
    {
        static $config;

        if ($config === null) {
            $config = (new Repository());
            $iterator = new FilesystemIterator(__DIR__.'/../config', FilesystemIterator::SKIP_DOTS);
            foreach ($iterator as $node) {
                $name = substr($node->getBasename(), 0, -4);
                $config->set($name, require $node->getRealPath());
            }
        }

        if ($path === null) {
            return $config->all();
        }

        return $config->get($path, $default);
    }
}
