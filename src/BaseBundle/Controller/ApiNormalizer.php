<?php

namespace BaseBundle\Controller;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Task;

class ApiNormalizer
{
    /** @var  ObjectNormalizer $objectNormalizer */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }


    public function normalizePeriods($periods)
    {
        $data = [];
        if (is_array($periods)) {
            foreach ($periods as $period) {
                $data[] = $this->conciseNormalizePeriod($period);
            }
        }

        return $data;
    }

    public function conciseNormalizePeriod(Period $period)
    {
        $timeCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime ? $dateTime->format('H:i') : '';
        };
        $this->objectNormalizer->setCallbacks(array('begin' => $timeCallback, 'end' => $timeCallback));

        $data = $this->objectNormalizer->normalize($period, null, array('groups' => array('concise')));

        return $data;
    }

    public function conciseNormalizeTask(Task $task)
    {
        return $this->objectNormalizer->normalize($task, null, ['groups' => ['concise']]);
    }

    public function normalizeTasks($tasks)
    {
        $callback = function ($task) {
            return $this->conciseNormalizeTask($task);
        };

        return $this->normalizeEntities($tasks, $callback);
    }

    public function normalizeEntities($entities, $callback)
    {
        $data = [];
        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $data[] = $callback($entity);
            }
        }

        return $data;
    }
}