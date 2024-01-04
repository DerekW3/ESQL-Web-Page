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
    $titolo = $_POST["titolo"];
    $visualizzaRisposte = $_POST["visualizzaRisposte"];
    $email = $_SESSION['email'];

    if ($visualizzaRisposte == "Sì") {
        $visualizzaRisposte = 1;
    } else {
        $visualizzaRisposte = 0;
    }

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL CREA_TEST('$titolo', '$visualizzaRisposte', '$email')";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }
    ?>
</body>

</html>