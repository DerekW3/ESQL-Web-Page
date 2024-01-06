<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Quesito</title>
</head>

<body>
    <?php
    $numeroQuesito = $_POST['numeroQuesito'];

    $titoloTest = $_COOKIE['titoloTest'];

    $tipoUtente = $_SESSION['tipoUtente'];
    $email = $_SESSION['email'];

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL ELIMINA_QUESITO('$numeroQuesito', '$titoloTest')";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    header("Location: ./view-test.php");
    exit();
    ?>
</body>

</html>