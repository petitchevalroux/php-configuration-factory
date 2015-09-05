<?php

namespace ConfigurationFactory\Loaders;

use ConfigurationFactory\Namespaced;

abstract class Loader extends Namespaced
{
    public function setNamespace($namespace)
    {
        parent::setNamespace(rtrim($namespace, static::SEPARATOR));
    }

    public function getConfigurationKey($configurationName)
    {
        return implode(static::SEPARATOR, [$this->getNamespace(), $configurationName]);
    }
}
