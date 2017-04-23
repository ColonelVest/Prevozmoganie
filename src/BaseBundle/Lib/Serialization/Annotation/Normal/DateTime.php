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
 */
final class DateTime implements Annotation
{
    const DATE_TYPE = 'date';
    const DATE_FORMAT = 'dmY';

    const TIME_TYPE = 'time';
    const TIME_FORMAT = 'H:i';

    const DATETIME_TYPE = 'datetime';
    const DATETIME_FORMAT = 'd.m.Y H:i';

    const FORMATS = [
        self::DATE_TYPE => self::DATE_FORMAT,
        self::TIME_TYPE => self::TIME_FORMAT,
        self::DATETIME_TYPE => self::DATETIME_FORMAT,
    ];

    /**
     * @var string
     */
    public $type = self::DATE_TYPE;

    /**
     * @var string
     */
    public $format;

    public function __construct()
    {
        //TODO: Добавить валидацию
    }


}