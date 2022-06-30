<?php

namespace Zoosimulator\Model;

class Animal
{
    protected $name;
    protected $healthPoints;
    protected $type;
    protected $maxLife;
    private $deathLevelPoints;
    private $health;

    const STATUS_ALIVE = 'ALIVE';
    const STATUS_DEAD = 'DEAD';
    public function __construct($name, $healthPoints, $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->maxLife = $healthPoints;
        $this->health = $this::STATUS_ALIVE;
        $this->healthPoints = floor($healthPoints); //Not taking Decimals at the moment
    }

    public function getName()
    {
        return $this->name;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getMaxLife()
    {
        return $this->maxLife;
    }

    public function getHealthPoints()
    {
        return $this->healthPoints;
    }

    public function setHealthPoints($healthPoints)
    {
        $this->healthPoints = floor($healthPoints); //Not taking Decimals at the moment
    }

    public function getDeathLevelPoints()
    {
        return $this->deathLevelPoints;
    }

    public function setDeathLevelPoints($deadHealthPoints)
    {
        $this->deathLevelPoints = $deadHealthPoints;
    }

    public function getHealth()
    {
        return $this->health;
    }
    public function setHealth($status)
    {
        $this->health = $status;
    }

    //Simulates 1 hour of time
    public function simulateTime($reduceHealthBy)
    {
        //Check if animal is already dead or not; if dead, do nothing
        if ($this->health == $this::STATUS_ALIVE) {
            $newHealthPoints = $this->healthPoints - ($this->healthPoints * ($reduceHealthBy / 100));
            //If animal new health is less than min health then set its health as dead
            if ($newHealthPoints < $this->deathLevelPoints) {
                $this->setHealth($this::STATUS_DEAD);
            }
            $this->setHealthPoints($newHealthPoints);
        }
    }

    //Simulates that the animal is being feeded
    public function feed($increaseHealthBy)
    {
        //Check if animal is already dead or not; if dead, do nothing
        if ($this->health == $this::STATUS_ALIVE) {
            $healthIncrease = $this->healthPoints + ($this->healthPoints * ($increaseHealthBy / 100));
            //Dont increase health more than its maxhealth
            $healthIncrease = ($healthIncrease > $this->maxLife ? $this->maxLife : $healthIncrease);
            $this->setHealthPoints($healthIncrease);
        }
    }
}