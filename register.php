<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once 'GoogleAuthenticator.php';

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function checkEmpty($field)
{
    if (empty(trim($field))) {
        return true;
    }
    return false;
}

function checkLength($field, $min, $max)
{
    $string = trim($field);
    $length = strlen($string);
    if ($length < $min || $length > $max) {
        return false;
    }
    return true;
}

function checkUsername($username)
{
    if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))) {
        return false;
    }
    return true;
}

function checkGmail($email)
{
    if (!preg_match('/^[\w.+\-]+@gmail\.com$/', trim($email))) {
        return false;
    }
    return true;
}

function userExist($db, $login, $email)
{
    $exist = false;

    $param_login = trim($login);
    $param_email = trim($email);

    $sql = "SELECT id FROM users WHERE login = :login OR email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":login", $param_login, PDO::PARAM_STR);
    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $exist = true;
    }

    unset($stmt);

    return $exist;
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    if (checkEmpty($_POST['login']) === true) {
        $errmsg .= "<p>Zadajte login.</p>";
    } elseif (checkLength($_POST['login'], 6, 32) === false) {
        $errmsg .= "<p>Login musi mat min. 6 a max. 32 znakov.</p>";
    } elseif (checkUsername($_POST['login']) === false) {
        $errmsg .= "<p>Login moze obsahovat iba velke, male pismena, cislice a podtrznik.</p>";
    }

    if (userExist($db, $_POST['login'], $_POST['email']) === true) {
        $errmsg .= "Pouzivatel s tymto e-mailom / loginom uz existuje.</p>";
    }

    if (checkGmail($_POST['email'])) {
        $errmsg .= "Prihlaste sa pomocou Google prihlasenia";
    }


    if (empty($errmsg)) {
        $sql = "INSERT INTO users (fullname, login, email, password, 2fa_code) VALUES (:fullname, :login, :email, :password, :2fa_code)";

        $fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
        $email = $_POST['email'];
        $login = $_POST['login'];
        $hashed_password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

        $g2fa = new PHPGangsta_GoogleAuthenticator();
        $user_secret = $g2fa->createSecret();
        $codeURL = $g2fa->getQRCodeGoogleUrl('Olympic Games', $user_secret);

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":fullname", $fullname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":2fa_code", $user_secret, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $qrcode = $codeURL;
        } else {
            echo "Ups. Nieco sa pokazilo";
        }

        unset($stmt);
    }
    unset($pdo);
}

?>

<!doctype html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrácia</title>

    <style>
        html {
            max-width: 70ch;
            padding: 3em 1em;
            margin: auto;
            line-height: 1.75;
            font-size: 1.25em;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 3em 0 1em;
        }

        p,
        ul,
        ol {
            margin-bottom: 2em;
            color: #1d1d1d;
            font-family: sans-serif;
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
            <h1>Registrácia</h1>
            <h2>Vytvorenie konta</h2>
        </hgroup>
    </header>
    <main>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="firstname">
                Meno:
                <input type="text" name="firstname" value="" id="firstname" placeholder="napr. Jonatan" required>
            </label>

            <label for="lastname">
                Priezvisko:
                <input type="text" name="lastname" value="" id="lastname" placeholder="napr. Petrzlen" required>
            </label>

            <br>

            <label for="email">
                E-mail:
                <input type="email" name="email" value="" id="email" placeholder="napr. jpetrzlen@example.com" required>
            </label>

            <label for="login">
                Login:
                <input type="text" name="login" value="" id="login" placeholder="napr. jperasin" required">
            </label>

            <br>

            <label for="password">
                Heslo:
                <input type="password" name="password" value="" id="password" required>
            </label>

            <button type="submit">Vytvorit účet</button>

            <?php
            if (!empty($errmsg)) {
                echo $errmsg;
            }
            if (isset($qrcode)) {
                $message = '<p>Naskenuj QR kod do aplikacie Authenticator: <br><img src="' . $qrcode . '" alt="qr kod"></p>';

                echo $message;
                echo '<p>Prihlás sa: <a href="login.php" role="button">Login</a></p>';
            }
            ?>

        </form>
        <p>Máš konto? <a href="login.php">Prihlás sa!.</a></p>
    </main>
</body>

</html>