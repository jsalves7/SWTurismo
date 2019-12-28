<?php

    require_once('../business_rules/SWTurismo.php');
    require_once('../business_rules/Admin.php');

    $conn = new SWTurismo('../business_rules/configFile.ini');

    $conn->isAdminLoggedOff();

    $idActivity = $conn->idActivity($_GET['id']);

    if ($idActivity == null){
        header("location:admin.php");
    }

    if ($idActivity['idAdmin'] != $_SESSION['admin']->idAdmin()){
        header("location:admin.php");
    }

    $success = "";

    if(isset($_POST['name']) || isset($_POST['desc'])){
        $conn->updateActivity($idActivity['idActivity'], $_POST['name'], $_POST['desc'], $_SESSION['admin']->idAdmin());

        $success =  "<script> alert('A atividade foi editada com sucesso!') </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Admin | Editar Atividade</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="index.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="admin.php">Atividades</a></li>
            <li><a href="Contactos">Contactos</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <form method="get" class="searchForm">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="updateActivity-container">
        <div class="activityTitle-container">
            <h2>Editar <?php echo $idActivity['name'] ?></h2>
        </div>

        <div class="updateActivityForm-container">
            <form class="updateActivity-form" method="post">
                <label class="labelName" for="name"><b>Nome</b></label>
                <input type="text" placeholder="Nome" name="name" value="<?php echo $idActivity['name'] ?>">

                <label class="labelDescription" for="desc"><b>Descrição</b></label>
                <textarea cols="30" rows="10" placeholder="Descrição..." name="desc"><?php echo $idActivity['desc'] ?></textarea>

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
