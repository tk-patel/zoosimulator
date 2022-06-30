<?php

namespace Zoosimulator\Model;

class Monkey extends Animal
{
    private $deathLevel = 30;
    public function __construct($name, $healthPoints, $type)
    {
        parent::__construct($name, $healthPoints, $type);
        $this->setDeathLevelPoints($healthPoints * ($this->deathLevel / 100));
    }

}