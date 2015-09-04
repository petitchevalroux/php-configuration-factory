<?php

use Faker\Factory as FakerFactory;
use ConfigurationFactory\Factory as ConfigurationFactory;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FakerFactory
     */
    private $faker;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = FakerFactory::create();
    }

    public function testGetLoaderException()
    {
        $this->setExpectedException('\ConfigurationFactory\Exception', 'loader not setted');
        $factory = new ConfigurationFactory();
        $factory->get($this->faker->text());
    }

    public function testSetLoaderNamespaceException()
    {
        $expectedConfiguration = $this->faker->name;

        $loader = $this->getMockBuilder('\ConfigurationFactory\Loaders\Php')
                ->setMethods(['getConfigurationKey', 'loadByKey'])
                ->getMock();
        $loader->expects($this->any())
                ->method('getConfigurationKey')
                ->willReturn($this->faker->name);
        $loader->expects($this->any())
                ->method('loadByKey')
                ->willReturn($expectedConfiguration);

        $this->setExpectedException('\ConfigurationFactory\Exception', 'namespace not setted');
        $factory = new ConfigurationFactory();
        $factory->setLoader($loader);
    }

    public function testGet()
    {
        $expectedConfiguration = $this->faker->name;

        $loader = $this->getMockBuilder('\ConfigurationFactory\Loaders\Php')
                ->setMethods(['getConfigurationKey', 'loadByKey'])
                ->getMock();
        $loader->expects($this->once())
                ->method('getConfigurationKey')
                ->willReturn($this->faker->name);
        $loader->expects($this->once())
                ->method('loadByKey')
                ->willReturn($expectedConfiguration);

        $factory = new ConfigurationFactory();
        $factory->setNamespace($this->faker->name);
        $factory->setLoader($loader);
        $this->assertEquals(
                $expectedConfiguration, $factory->get($this->faker->name)
        );
    }
}
