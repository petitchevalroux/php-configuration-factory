<?php

namespace ConfigurationFactory;

use ConfigurationFactory\Loaders\Loader;

class Factory extends Namespaced
{
    protected static $configurations = [];

    /**
     * Configuration factory loader.
     *
     * @var Loader
     */
    private $loader;

    /**
     * Set configuration factory loader.
     *
     * @param Loader $loader
     */
    public function setLoader(Loader $loader)
    {
        $this->loader = $loader;
        $this->loader->setNamespace($this->getNamespace());
    }

    /**
     * Return configuration factory loader.
     *
     * @return Loader
     *
     * @throws Exception
     */
    public function getLoader()
    {
        if (!isset($this->loader)) {
            throw new Exception('loader not setted');
        }

        return $this->loader;
    }

    /**
     * Return configuration.
     *
     * @param string $name
     *
     * @return Configuration
     */
    public function get($name)
    {
        $loader = $this->getLoader();
        $configurationKey = $loader->getConfigurationKey($name);
        $configuration = &static::$configurations[$configurationKey];
        if (!isset($configuration)) {
            $configuration = $loader->loadByKey($configurationKey);
        }

        return $configuration;
    }
}
