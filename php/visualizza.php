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

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL VISUALIZZA_RISPOSTE('$titoloTest')";
        $result = $pdo->query($sql);

        header("Location: ./view-test.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    ?>
</body>

</html>