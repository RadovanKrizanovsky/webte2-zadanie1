<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
?>

<!doctype html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>OAuth2 cez Google - Zabezpecena stranka</title>

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
  <header>
    <hgroup>
      <h1>Zabezpečená stránka</h1>
      <h2>Secured</h2>
    </hgroup>
  </header>
  <main>

    <h3>Zdravím
      <?php echo $fullname ?>
    </h3>
    <p>Email:
      <?php echo $email ?>
    </p>
    <p>Identifikator je:
      <?php echo $id ?>
    </p>
    <p>Meno:
      <?php echo $name ?>, Priezvisko:
      <?php echo $surname ?>
    </p>

    <a role="button" class="secondary" href="logout.php">Odhlásiť sa</a></p>
    <a role="button" href="index.php">Hlavná stránka</a></p>


  </main>
</body>

</html>