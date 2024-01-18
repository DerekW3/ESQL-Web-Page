<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Tabella</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client('mongodb://127.0.0.1:27017');

    $database = $mongoClient->selectDatabase("ESQL");
    $collection = $database->selectCollection("Logs");

    $nome = $_POST['nome'];

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
        $sql = "CALL CREA_ESERCIZIO('$nome', '$email')";
        $result = $pdo->query($sql);

        $sql = "CREATE TABLE " . $nome . " ( SKIP_ATTRIBUTE INT ) ENGINE = InnoDB";
        $result = $pdo->query($sql);

        $event = [
            "timestamp" => time(),
            "tipo_event" => "crea_esercizio",
            "descrizione" => $nome
        ];

        $result = $collection->insertOne($event);
    } catch (PDOException $e) {
        echo ("Fallito") . $e->getMessage();
        exit();
    }

    header("Location: ../php/professor-homepage.php");
    exit();
    ?>
</body>

</html>