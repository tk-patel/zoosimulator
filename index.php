<?php
//Zoo Simulator start point
require 'src/Animal.php';
require 'src/Monkey.php';
require 'src/Giraffe.php';
require 'src/Elephant.php';

use Zoosimulator\Model\Animal;
use Zoosimulator\Model\Monkey;
use Zoosimulator\Model\Giraffe;
use Zoosimulator\Model\Elephant;


//Initialize new session for the user
session_start();

//Set zooAnimals from session if found or create a new array
$zooAnimals = isset($_SESSION["zooAnimals"]) ? $_SESSION["zooAnimals"] : array();
$time = isset($_SESSION["time"]) ? $_SESSION["time"] : new \DateTime();

//Initialize Zoo default Variables
$defaultAnimalsOfEachKind = 5;
$animalTypesAndHealth = [
  ['class' => 'Zoosimulator\Model\Monkey', 'type' => 'Monkey', 'health' => 100],
  ['class' => 'Zoosimulator\Model\Giraffe', 'type' => 'Giraffe', 'health' => 150],
  ['class' => 'Zoosimulator\Model\Elephant', 'type' => 'Elephant','health' => 200]
];

if (isset($_SESSION["zooAnimals"]) && count($zooAnimals) > 0) {
  //Simulator is running, check if any action is triggered
  if ($_POST) {
    //check action type
    if ($_POST['action'] == 'Reset Simulator') {
      // remove all session variables
      session_unset();
      // destroy the session
      session_destroy();
      header('Location: ' . '/');
    }elseif($_POST['action'] == 'Feed zoo'){
      //For each animal type, generate random value between 10 to 25 and feed these animals
      foreach($animalTypesAndHealth as $animalData){
        //Generate random number between
        $feedHealthBy = rand(10,25);
        foreach($zooAnimals as $animal){
          if($animal->getType() == $animalData['type']){
            $animal->feed($feedHealthBy);
          }
        }
      }
    }elseif ($_POST['action'] == 'Provoke one hour') {
      //For each animal, generate random value between 0 to 20 and reduce their health
      foreach ($zooAnimals as $animal) {
        //Generate random number between
        $reduceHealthBy = rand(0, 20);
        $animal->simulateTime($reduceHealthBy);
      }
      //Increment TIme
      $time->add(new \DateInterval('PT1H')); //add 1 hour
    }
  }
}
else {
  foreach ($animalTypesAndHealth as $animal) {
    for ($i = 0; $i < $defaultAnimalsOfEachKind; $i++) {
      $newAnimal = new $animal['class']($animal['type'] . " " . ($i + 1), $animal['health'], $animal['type']);
      array_push($zooAnimals, $newAnimal);
    }
  }
  $_SESSION["zooAnimals"] = $zooAnimals;
  $_SESSION["time"] = new \DateTime();
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Zoo simulator</title>
  </head>
  <body>
  <div class="container">
    <h1 style="text-align:center;" class="mt-2">Zoo Simulator</h1>
    <form method="POST">
      <div class="row">
        <div class="col text-center">
          <input type="submit" class="btn btn-secondary" name="action" value="Reset Simulator" />
        </div>
      </div>
      <div class="row">
        <div class="col text-center mt-2">
          <input type="submit" class="btn btn-success" name="action" value="Feed zoo" />
          <input type="submit" class="btn btn-danger" name="action" value="Provoke one hour" />
        </div>
      </div>
    </form>
    <h3 class="mt-2 text-center">Zoo Animals</h3>
    <h5 class="mt-2 text-center">Zoo Time: <?= $time->setTimezone(new DateTimeZone('America/Toronto'))->format('Y-m-d H\h') ?></h5>
    <div class="mt-2 row row-cols-5 text-center">
      <?php foreach($zooAnimals as $animal){ ?>
        <div class="col my-2">
          <?= $animal->getName() ?> <br />
          (Max: <?= $animal->getMaxLife() ?>, Min: <?= $animal->getDeathLevelPoints() ?>)<br />
          Current Health: <?= $animal->getHealthPoints() ?> <br />
          <span class="<?php echo ($animal->getHealth() == Animal::STATUS_DEAD ? 'text-danger' : ($animal->getHealth() == Elephant::STATUS_CRITICAL ? 'text-warning' : 'text-success')) ?>"><?= $animal->getHealth() ?></span>
        </div>
      <?php } ?>
    </div>
</div>
    


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>