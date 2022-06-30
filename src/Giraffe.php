<?php

namespace Zoosimulator\Model;

class Giraffe extends Animal
{
    private $deathLevel = 50;

    public function __construct($name, $healthPoints, $type)
    {
        parent::__construct($name, $healthPoints, $type);
        $this->setDeathLevelPoints($healthPoints * ($this->deathLevel / 100));
    }
}