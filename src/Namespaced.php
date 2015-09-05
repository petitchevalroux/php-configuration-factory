<?php

namespace ConfigurationFactory;

class Namespaced
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * Set namespace.
     *
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Set namespace.
     *
     * @return string
     *
     * @throws Exception
     */
    protected function getNamespace()
    {
        if (!isset($this->namespace)) {
            throw new Exception('namespace not setted');
        }

        return $this->namespace;
    }
}
