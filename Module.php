<?php

namespace ZfcUserDoctrineORM;

use Doctrine\ORM\Mapping\Driver\XmlDriver;

class Module
{
    public function onBootstrap($e)
    {
        $app     = $e->getParam('application');
        $sm      = $app->getServiceManager();
        $options = $sm->get('zfcuser_module_options');

        // Add the default entity driver only if specified in configuration
        if ($options->getEnableDefaultEntities()) {
            $chain = $sm->get('doctrine.driver.orm_default');
            $chain->addDriver(new XmlDriver(__DIR__ . '/config/xml/zfcuserdoctrineorm'), 'ZfcUserDoctrineORM\Entity');
        }
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'zfcuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
            ],
            'factories' => [
                'zfcuser_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');
                    return new Options\ModuleOptions(isset($config['zfcuser']) ? $config['zfcuser'] : []);
                },
                'zfcuser_user_mapper' => function ($sm) {
                    return new \ZfcUserDoctrineORM\Mapper\User(
                        $sm->get('zfcuser_doctrine_em'),
                        $sm->get('zfcuser_module_options')
                    );
                },
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
