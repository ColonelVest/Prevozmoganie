<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 25/06/2017
 * Time: 23:32
 */

namespace BaseBundle\Services;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Doctrine\Common\Inflector\Inflector;

/**
 * Service for generation template code for new entity
 * Class PVGenerator
 * @package BaseBundle\Services
 */
class PVGenerator extends Generator
{
    private $entityFullName;
    private $entityName;
    private $fileSystem;
    private $rootDir;
    private $container;
    /** @var  BundleInterface */
    private $bundle;

    public function __construct(Filesystem $fileSystem, $rootDir, ContainerInterface $container)
    {
        $this->rootDir = $rootDir . '/..';
        $this->fileSystem = $fileSystem;
        $this->container = $container;
    }

    public function generate($entityName)
    {
        $this->initData($entityName);
        $this->generateControllerTest();
        $this->generateController();
        $this->generateHandler();
    }

    private function initData($entityFullName)
    {
        $this->entityFullName = $entityFullName;
        $delimiterPosition = strpos($entityFullName, ':');
        $bundleName = substr($entityFullName, 0, $delimiterPosition);
        $this->bundle = $this->container->get('kernel')->getBundle($bundleName);

        $this->entityName = substr($entityFullName, $delimiterPosition + 1);

        $skeletonDir = $this->rootDir . '/src/BaseBundle/Resources/views/generator';
        $this->setSkeletonDirs([$skeletonDir]);
    }

    private function generateHandler()
    {
        $target = $this->rootDir . '/src/' . $this->bundle->getName() . '/Services/' . $this->entityName . 'Handler.php';
        $this->renderFile('handler.php.twig', $target, [
            'bundleName' => $this->bundle->getName(),
            'entityName' => $this->entityName
        ]);
        $this->addHandlerToConfig();
    }

    private function generateControllerTest()
    {
        $target = $this->rootDir . '/tests/' . $this->bundle->getName() . '/Controller/' . $this->entityName . 'ControllerTest.php';
        $this->renderFile('test_controller.php.twig', $target, [
            'bundleName' => $this->bundle->getName(),
            'entityName' => $this->entityName,
            'entityPluralName' => Inflector::pluralize($this->entityName)
        ]);
    }

    private function generateController()
    {
        $target = $this->rootDir . '/src/' . $this->bundle->getName() . '/Controller/' . $this->entityName . 'Controller.php';
        $this->renderFile('controller.php.twig', $target, [
            'bundleName' => $this->bundle->getName(),
            'entityName' => $this->entityName,
            'entityPluralName' => Inflector::pluralize($this->entityName)
        ]);
    }

    private function addHandlerToConfig()
    {
        $configFile = $target = $this->rootDir . '/src/' . $this->bundle->getName() . '/Resources/config/services.yml';
        $currentContents = file_get_contents($configFile);
        $newContent = $currentContents . $this->getImportHandlerConfigCode();

        if (false === $this->dump($configFile, $newContent)) {
            throw new \RuntimeException(sprintf('Could not write file %s ', $configFile));
        }
    }

    private function getImportHandlerConfigCode()
    {
        $handlerConciseName = $this->entityName . 'Handler';
        return "\n\n  " . strtolower($this->entityName) . '_handler:' .
        "\n    class: ". $this->bundle->getName() .'\\Services\\' . $handlerConciseName . "\n" .
        '    arguments:
        - \'@doctrine.orm.entity_manager\'
        - \'@validator\'';
    }
}