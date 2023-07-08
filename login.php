<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once 'GoogleAuthenticator.php';

session_start();

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: restricted.php");
    exit;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT fullname, email, login, password, created_at, 2fa_code FROM users WHERE login = :login";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(":login", $_POST["login"], PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $hashed_password = $row["password"];

            if (password_verify($_POST['password'], $hashed_password)) {
                $g2fa = new PHPGangsta_GoogleAuthenticator();
                if ($g2fa->verifyCode($row["2fa_code"], $_POST['2fa'], 2)) {

                    $_SESSION["loggedin"] = true;
                    $_SESSION["login"] = $row['login'];
                    $_SESSION["fullname"] = $row['fullname'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["created_at"] = $row['created_at'];

                    header("location: restricted.php");
                } else {
                    echo "Zlý kod 2FA.";
                }
            } else {
                echo "Zlé meno alebo heslo.";
            }
        } else {
            echo "Zlé meno alebo heslo.";
        }
    } else {
        echo "Chyba!";
    }

    unset($stmt);
    unset($db);
}

?>

<!doctype html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login/register s 2FA - Login</title>

    <style>
        html {
            max-width: 70ch;
            padding: 3em 1em;
            margin: auto;
            line-height: 1.75;
            font-size: 1.25em;
        }

        p,
        ul,
        ol {
            margin-bottom: 2em;
            color: #1d1d1d;
            font-family: sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 3em 0 1em;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
    <header>
        <hgroup>
            <h1>Prihlasenie</h1>
            <h2>Prosím prihláste sa</h2>
        </hgroup>
    </header>
    <main>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <label for="login">
                Login:
                <input type="text" name="login" value="" id="login" required>
            </label>
            <br>
            <label for="password">
                Heslo:
                <input type="password" name="password" value="" id="password" required>
            </label>
            <br>
            <label for="2fa">
                2-Factor-Authentification kód:
                <input type="number" name="2fa" value="" id="2fa" required>
            </label>

            <button type="submit">Prihlásiť sa</button>
        </form>
        <p>Ešte nemáš vytvorený účet? <a href="register.php">Zaregistruj sa!.</a></p>
    </main>
</body>

</html>