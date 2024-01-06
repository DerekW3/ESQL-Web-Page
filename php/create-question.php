<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $titoloTest = $_COOKIE['titoloTest'];
    $descrizione = $_POST['descrizione'];
    $livelloDifficolta = $_POST['livelloDifficolta'];
    $tipoQuesito = $_POST['tipoQuesito'];

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL CREA_QUESITO('$livelloDifficolta', '$descrizione', '$titoloTest')";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        echo ("Azione Fallito") . $e->getMessage();
        exit();
    }

    try {
        $sql = "SELECT COUNT(*) AS numeroQuesito FROM QUESITI WHERE TitoloTest LIKE '$titoloTest'";
        $result = $pdo->query($sql);

        foreach ($result as $row) {
            $numeroQuesito = $row['numeroQuesito'];
        }

        setcookie("numeroQuesito", $numeroQuesito, time() + 3.6e6);
    } catch (PDOException $e) {
        echo ("Azione Fallito") . $e->getMessage();
        exit();
    }
    if ($tipoQuesito == "codice") {
        header("Location: ../webpages/create-codice.html");
        exit();
    } else {
        header("Location: ../webpages/create-risposta-chiusa.html");
        exit();
    }
    ?>
</body>

</html>