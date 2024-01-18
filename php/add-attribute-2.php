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
    $nome = $_POST['nome'];
    $tipoData = $_POST['tipoData'];
    $primaryKey = $_POST['primaryKey'];
    $nomeTabella = $_POST['nomeTabella'];

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
        $sql = "ALTER TABLE " . $nomeTabella . " ADD COLUMN " . $nome . " " . $tipoData;
        $result = $pdo->query($sql);

        if ($primaryKey == "si") {
            $sql = "ALTER TABLE " . $nomeTabella . " ADD PRIMARY KEY (" . $nome . ")";
            $result = $pdo->query($sql);
        }
    } catch (PDOException $e) {
        echo ("Fallito") . $e->getMessage();
        exit();
    }

    header("Location: ./professor-homepage.php");
    exit();
    ?>
</body>

</html>