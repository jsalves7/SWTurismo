<?php

    require_once('../business_rules/SWTurismo.php');
    require_once('../business_rules/Admin.php');

    $conn = new SWTurismo('../business_rules/configFile.ini');

    $conn->isAdminLoggedOff();

    $success = "";

    if (isset($_POST['name']) && isset($_POST['desc']) && isset($_FILES['image']['name'])) {

        // specifying the the folder path
        $folderPath = "../img/";
        // specifying the file
        $destination = $folderPath.$_FILES['image']['name'];
        // temporarily storing the image
        $temp = $_FILES['image']['tmp_name'];

        move_uploaded_file($temp, $destination);

        $conn->addActivity($_POST['name'], $_POST['desc'], $_SESSION['admin']->idAdmin(), $_FILES['image']['name']);

        $success =  "<script> alert('A atividade foi criada com sucesso!') </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Admin | Criar Atividade</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="index.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="admin.php">Atividades</a></li>
            <li><a href="contactos.php">Contactos</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <form method="get" class="searchForm">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="createActivity-container">
        <div class="activityTitle-container">
            <h2>Criar Atividade</h2>
        </div>
        <div class="createActivityForm-container">
            <form class="createActivity-form" method="post" enctype="multipart/form-data">
                <label class="labelName" for="name"><b>Nome</b></label>
                <input type="text" placeholder="Nome" name="name" required>

                <label class="labelDescription" for="desc"><b>Descrição</b></label>
                <textarea cols="30" rows="10" placeholder="Descrição..." name="desc" required></textarea>

                <label class="labelImage" for="image"><b>Imagem</b></label>
                <input type="file" name="image" required>
                <button type="submit"><b>Guardar</b></button>
            </form>
        </div>
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
                <li><img src="../img/facebook.svg" alt=""></li>
                <li><img src="../img/instagram.svg" alt=""></li>
                <li><img src="../img/twitter.svg" alt=""></li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html>