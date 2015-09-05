<?php

use Faker\Factory as FakerFactory;
use ConfigurationFactory\Loaders\Php as Loader;

class LoadersPhpTest extends PHPUnit_Framework_TestCase
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

    public function testGetConfigurationKey()
    {
        $loader = new Loader();
        $name = $this->faker->name;
        $namespace = $this->faker->name;
        $loader->setNamespace($namespace);
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, [$namespace, $name]).'.php', $loader->getConfigurationKey($name));
    }

    public function testLoad()
    {
        $expectedVarValue = $this->faker->text();
        $configDirectory = sys_get_temp_dir();
        $loader = new Loader();
        $loader->setNamespace($configDirectory);
        $tempname = tempnam($configDirectory, '');
        $config = basename($tempname);
        $phpFile = $tempname.'.php';
        if (is_file($phpFile)) {
            unlink($phpFile);
        }
        file_put_contents($phpFile, "<?php\n\$dummy='"
                .addslashes($expectedVarValue)
                ."';\n");

        $this->assertEquals($expectedVarValue, $loader->loadByKey($loader->getConfigurationKey($config))->dummy);
        unlink($phpFile);
        unlink($tempname);
    }
}
