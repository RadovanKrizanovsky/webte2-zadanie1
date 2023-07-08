<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}


try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM person";
    $stmt = $db->query($query);
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

if (!empty($_POST) && !empty($_POST['name'])) {
    $sql = "INSERT INTO person (name, surname, birth_day, birth_place, birth_country) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country']]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
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
        <h1>Admin panel</h1>
        <h2>Pridaj sportovca</h2>
        <form action="#" method="post">
            <div class="mb-3">
                <label for="InputName" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="InputName" required>
            </div>
            <div class="mb-3">
                <label for="InputSurname" class="form-label">Surname:</label>
                <input type="text" name="surname" class="form-control" id="InputSurname" required>
            </div>
            <div class="mb-3">
                <label for="InputDate" class="form-label">birth day:</label>
                <input type="date" name="birth_day" class="form-control" id="InputDate" required>
            </div>
            <div class="mb-3">
                <label for="InputbrPlace" class="form-label">birth place:</label>
                <input type="text" name="birth_place" class="form-control" id="InputBrPlace" required>
            </div>
            <div class="mb-3">
                <label for="InputBrCountry" class="form-label">birth country:</label>
                <input type="text" name="birth_country" class="form-control" id="InputBrCountry" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <form action="#" method="post">
            <select name="person_id">
                <?php
                foreach ($persons as $person) {
                    echo '<option value="' . $person['id'] . '">' . $person['name'] . ' ' . $person['surname'] . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <td>Meno</td>
                    <td>Priezvisko</td>
                    <td>Narodenie</td>
                </tr>
            </thead>
            <tbody>
                <?php //var_dump($results) 
                foreach ($persons as $person) {
                    $date = new DateTimeImmutable($person["birth_day"]);
                    echo "<tr><td><a href='editPerson.php?id=" . $person["id"] . "'>" . $person["name"] . "</a></td><td>" . $person["surname"] . "</td><td>" . $date->format("d.m.Y") . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>