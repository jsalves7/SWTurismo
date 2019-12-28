<?php

    require_once('business_rules/SWTurismo.php');
    require_once('business_rules/User.php');

    $conn = new SWTurismo('business_rules/configFile.ini');

    $conn->isUserLoggedIn();

    if (isset($_POST['password']) && isset($_POST['username']) && isset($_POST['name'])) {

        // filter special characters
        foreach ($_POST as $key => $value) {
            $_POST["$key"] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        $conn->signUp($_POST['name'], $_POST['username'],$_POST['password']);

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <title>SWTurismo | Registar</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="index.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="Contactos">Contactos</a></li>
        </ul>

        <form method="get" class="searchForm">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="login-container">
        <h1>Registar</h1>

        <form class="login-form" method="post">
            <label for="name" class="labelName"><b>Name</b></label>
            <input type="text" id="name" placeholder="Name" name="name" required>

            <label for="username"><b>Username</b></label>
            <input type="text" id="username" placeholder="Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" id="password" placeholder="Password" name="password" required>

            <button type="submit"><b>Registar</b></button>
        </form>
    </div>

    <footer class="footer">
        <div class="footerText-container">
            <h1>SWTurismo</h1>
            <h3>TO TRAVEL IS TO LIVE</h3>
            <p>O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro.O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. </p>
        </div>

        <div class="footerSocial-container">
            <h2>Copyrigth 2019 - SWTurismo</h2>

            <ul class="social">
                <li><img src="img/facebook.svg" alt=""></li>
                <li><img src="img/instagram.svg" alt=""></li>
                <li><img src="img/twitter.svg" alt=""></li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html>

