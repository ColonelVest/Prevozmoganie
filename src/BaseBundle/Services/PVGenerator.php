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
        $this->rootDir = $rootDir;
        $this->fileSystem = $fileSystem;
        $this->container = $container;
    }

    public function generate($entityName)
    {
        $this->initData($entityName);
        $this->generateController();
    }

    private function initData($entityFullName)
    {
        $this->entityFullName = $entityFullName;
        $bundleNameEndPosition = strpos($entityFullName, '\\');
        $bundleName = substr($entityFullName, 0, $bundleNameEndPosition);
        $this->bundle = $this->container->get('kernel')->getBundle($bundleName);

        $entityNameBeginPosition = strrpos($entityFullName, '\\') + 1;
        $this->entityName = substr($entityFullName, $entityNameBeginPosition);

        $skeletonDir = $this->rootDir . '/../src/BaseBundle/Resources/views/generator';
        $this->setSkeletonDirs([$skeletonDir]);
    }

    private function generateHandler()
    {
        $target = $this->rootDir . '/../src/' . $this->bundle->getName() . '/Services/' . $this->entityName . 'Handler.php';
        $this->renderFile('handler.php.twig', $target, [
            'bundleName' => $this->bundle->getName(),
            'entityName' => $this->entityName
        ]);
    }

    private function generateController()
    {
        $target = $this->rootDir . '/../src/' . $this->bundle->getName() . '/Controller/' . $this->entityName . 'Controller.php';
        $this->renderFile('controller.php.twig', $target, [
            'bundleName' => $this->bundle->getName(),
            'entityName' => $this->entityName,
            'entityFullName' => $this->entityFullName,
            'entityPluralName' => Inflector::pluralize($this->entityName)
        ]);
    }

    private function generateTestClass()
    {
        
    }
}