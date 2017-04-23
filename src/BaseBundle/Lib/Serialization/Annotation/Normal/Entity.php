<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 23.04.17
 * Time: 14:17
 */

namespace BaseBundle\Lib\Serialization\Annotation\Normal;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY","ANNOTATION"})
 * Class Entity
 * @package BaseBundle\Lib\Normal
 */
final class Entity implements Annotation
{
    /**
     * @var string
     */
    public $className;

    public function __construct()
    {
        //TODO: Здесь можно реализовать валидацию значений
    }
}