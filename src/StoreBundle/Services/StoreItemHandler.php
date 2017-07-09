<?php

namespace StoreBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class StoreItemHandler extends EntityHandler
{
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('StoreItem.php');
    }
}