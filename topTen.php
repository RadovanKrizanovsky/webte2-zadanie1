<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');



try {
  $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //$query = "SELECT * FROM person";
  $query = "SELECT
    surname,
      COUNT(surname) AS value_occurence
  FROM person
  JOIN placement
    ON person.id = placement.person_id 
  JOIN games
    ON games.id = placement.games_id
  WHERE placement.placing = 1
  GROUP BY 
    surname
  ORDER BY 
    value_occurence DESC
  LIMIT 10;";
  $stmt = $db->query($query);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Top 10</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" href="mystyle.css">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Olympijské hry</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Domov <span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="topTen.php">Top 10</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="allRegAndLogins.php">Prihlásenie/registrácia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="restricted.php">Privátna zóna</a>
        </li>
      </ul>
    </div>
  </nav>


  <div class="container-md">
    <h1>Top 10 olympionikov</h1>
    <table id="example" class="display" style="width:100%">
      <thead>
        <tr>
          <td>Meno</td>
          <td>Počet</td>
        </tr>
      </thead>
      <tbody>
        <?php //var_dump($results) 
        
        foreach ($results as $result) {
          echo "<tr><td>" . $result["surname"] . "</td><td>" . $result["value_occurence"] . "</td></tr>";

        }

        ?>
      </tbody>
    </table>
  </div>
  <script src="tableInitializator.js"></script>
</body>

</html>