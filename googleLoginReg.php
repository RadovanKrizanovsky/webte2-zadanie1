<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'vendor/autoload.php';
require_once('config.php');

$client = new Google\Client();
$client->setAuthConfig('client_secret.json');
$redirect_uri = "https://site139.webte.fei.stuba.sk/oh/redirectGoogle.php";
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
$auth_url = $client->createAuthUrl();

?>

<!doctype html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>OAuth2 cez Google</title>

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
    h3 {
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
      <h1>Google Login</h1>
      <h2>Auth</h2>
    </hgroup>
  </header>
  <main>

    <?php
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      echo '<h3>Zdravím ' . $_SESSION['name'] . '</h3>';
      echo '<p>Prihlaseny ako: ' . $_SESSION['email'] . '</p>';

      echo '<a role="button" class="secondary" href="adminGoogle.php">Admin konzola</a></p>';
      echo '<p><a role="button" href="restricted.php">Zabezpecena stranka</a>';
      echo '<a role="button" class="secondary" href="logout.php">Odhlas ma</a></p>';

    } else {
      echo '<h3>Neprihlásený</h3>';
      echo '<a role="button" href="' . filter_var($auth_url, FILTER_SANITIZE_URL) . '">Google login</a>';
    }
    ?>


  </main>
</body>

</html>