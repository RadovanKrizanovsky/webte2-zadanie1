<?php

session_start();

// Uvolni vsetky session premenne.
session_unset();

// Vymaz vsetky data zo session.
session_destroy();

// Ak nechcem zobrazovat obsah, presmeruj pouzivatela na hlavnu stranku.
// header('location:index.php');

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
    <h1>Boli ste uspesne odhlaseni</h1>
  </header>
  <main>
    <a role="button" href="index.php" class="secondary">Vrait sa na hlavnu stranku</a>
  </main>
</body>

</html>