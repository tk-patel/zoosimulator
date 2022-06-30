<?php

namespace Zoosimulator\Model;

class Elephant extends Animal
{
    private $deathLevel = 70;
    const STATUS_CRITICAL = 'CANT WALK';

    public function __construct($name, $healthPoints, $type)
    {
        parent::__construct($name, $healthPoints, $type);
        $this->setDeathLevelPoints($healthPoints * ($this->deathLevel / 100));
    }

    //Simulates 1 hour of time
    public function simulateTime($reduceHealthBy)
    {
        //Check if animal is already dead or not; if dead, do nothing
        if ($this->getHealth() == $this::STATUS_ALIVE) {
            $newHealthPoints = $this->getHealthPoints() - ($this->getHealthPoints() * ($reduceHealthBy / 100));
            //If animal new health is less than min health then set its health as dead
            if ($newHealthPoints < $this->getDeathLevelPoints()) {
                $this->setHealth($this::STATUS_CRITICAL);
            }
            $this->setHealthPoints($newHealthPoints);
        }
        else if ($this->getHealth() == $this::STATUS_CRITICAL) {
            $this->setHealth($this::STATUS_DEAD);
        }
    }

    //Simulates that the animal is being feeded
    public function feed($increaseHealthBy)
    {
        $newHealth = $this->getHealthPoints() + ($this->getHealthPoints() * ($increaseHealthBy / 100));
        //Check if animal is already dead or not; if dead, do nothing
        if ($this->getHealth() == $this::STATUS_ALIVE) {
            //Dont increase health more than its maxhealth
            $newHealth = ($newHealth > $this->getMaxLife() ? $this->getMaxLife() : $newHealth);
            $this->setHealthPoints($newHealth);
        }
        else if ($this->getHealth() == $this::STATUS_CRITICAL) {
            if ($newHealth >= $this->getDeathLevelPoints()) {
                $this->setHealth($this::STATUS_ALIVE);
                $this->setHealthPoints($newHealth);
            }
            else {
                $this->setHealth($this::STATUS_DEAD);
            }
        }
    }
}