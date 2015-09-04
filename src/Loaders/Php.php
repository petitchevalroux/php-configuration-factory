<?php

namespace ConfigurationFactory\Loaders;

use ConfigurationFactory\Configuration;

class Php extends Loader
{
    const SEPARATOR = DIRECTORY_SEPARATOR;

    /**
     * Return configuration key.
     *
     * @param string $name
     *
     * @return string
     */
    public function getConfigurationKey($name)
    {
        return parent::getConfigurationKey($name).'.php';
    }

    /**
     * Load configuration.
     *
     * @param string $key
     *
     * @return Configuration
     */
    public function loadByKey($key)
    {
        $configuration = new Configuration();
        require $key;
        $vars = get_defined_vars();
        unset($vars['configuration']);
        unset($vars['key']);
        foreach ($vars as $name => $value) {
            $configuration->{$name} = $value;
        }

        return $configuration;
    }
}
