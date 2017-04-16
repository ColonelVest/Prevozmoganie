<?php

namespace ErrorsBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class ErrorNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $error)
    {
        return $this->objectNormalizer->normalize($error, null, array('groups' => array('concise')));
    }

    public function fullNormalize(BaseEntity $error)
    {
        return $this->objectNormalizer->normalize($error, null, array('groups' => array('full')));
    }
}