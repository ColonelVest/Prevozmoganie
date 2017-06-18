<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 16:01
 */

namespace TaskBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class ChallengeHandler extends EntityHandler
{
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Challenge');
    }
}