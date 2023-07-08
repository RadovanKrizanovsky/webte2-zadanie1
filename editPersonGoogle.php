<?php

require_once('config.php');

session_start();

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
    $fullname = $_SESSION['fullname'];
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];

} else {
    header('Location: index.php');
}


if (!isset($_GET['id'])) {
    exit("id not exist");
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST) && !empty($_POST['name'])) {
        $sql = "UPDATE person SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=? where id=?";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country'], intval($_POST['person_id'])]);
    }

    $query = "SELECT * FROM person where id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['del_placement_id'])) {
        $sql = "DELETE FROM placement WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_POST['del_placement_id'])]);
    }

    $query = "select placement.*, games.city from placement join games on placement.games_id = games.id where placement.person_id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $placements = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h2>Info o športovcovi</h2>
        <form action="#" method="post">
            <input type="hidden" name="person_id" value="<?php echo $person['id']; ?>">
            <div class="mb-3">
                <label for="InputName" class="form-label">Meno:</label>
                <input type="text" name="name" class="form-control" id="InputName"
                    value="<?php echo $person['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputSurname" class="form-label">Priezvisko:</label>
                <input type="text" name="surname" class="form-control" id="InputSurname"
                    value="<?php echo $person['surname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputDate" class="form-label">Narodeniny:</label>
                <input type="date" name="birth_day" class="form-control" id="InputDate"
                    value="<?php echo $person['birth_day']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputbrPlace" class="form-label">Miesto narodenia:</label>
                <input type="text" name="birth_place" class="form-control" id="InputBrPlace"
                    value="<?php echo $person['birth_place']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputBrCountry" class="form-label">Krajina narodenia:</label>
                <input type="text" name="birth_country" class="form-control" id="InputBrCountry"
                    value="<?php echo $person['birth_country']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>


        <h2>Umiestnenia</h2>
        <table class="table">
            <thead>
                <tr>
                    <td>Umiestnenie</td>
                    <td>disciplína</td>
                    <td>OH</td>
                    <td>Akcia</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($placements as $placement) {
                    echo '<tr><td>' . $placement['placing'] . '</td><td>' . $placement['discipline'] . '</td><td>' . $placement['city'] . '</td><td>';
                    echo '<form action="#" method="post"><input type="hidden" name="del_placement_id" value="' . $placement['id'] . '"><button type="submit" class="btn btn-primary">Vymaz</button></form>';
                    echo '</td></tr>';
                }
                ?>
            </tbody>
        </table>



        </table>
    </div>
</body>

</html>