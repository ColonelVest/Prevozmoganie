<?php

namespace BaseBundle\Models;


interface RepetitiveInterface
{
    public function getBeginDate() : ?\DateTime;
    public function getEndDate() : ?\DateTime;
    public function getDaysOfWeek() : ?array ;
    public function getWeekFrequency() : ?int;

}