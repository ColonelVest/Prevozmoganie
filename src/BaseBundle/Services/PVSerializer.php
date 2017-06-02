<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 31.05.17
 * Time: 22:26
 */

namespace BaseBundle\Services;

use Symfony\Component\Serializer\Serializer;

class PVSerializer
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function normalizeNested($entity)
    {
        return $this->serializer->normalize($entity, null, ['groups' => ['nested']]);
    }

    public function normalizeNestedEntities($entities)
    {
        $data = [];
        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $data[] = $this->normalizeNested($entity);
            }
        }

        return $data;
    }

    public function fullNormalize($entity)
    {
        return $this->serializer->normalize($entity, null, ['groups' => ['full']]);
    }
}