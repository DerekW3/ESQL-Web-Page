<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Codice</title>
</head>

<body>
    <?php
    $titoloTest = $_COOKIE['titoloTest'];
    $numeroQuesito = $_COOKIE['numeroQuesito'];
    $testo = $_POST['testo'];

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL CREA_RISPOSTA_CHIUSA('$numeroQuesito', '$titoloTest', '$testo')";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        echo ("Azione Fallito") . $e->getMessage();
        exit();
    }

    header("Location: ../webpages/create-risposta-chiusa.html");
    exit();
    ?>
</body>

</html>