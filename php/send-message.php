<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manda Messaggio</title>
</head>

<body>
    <?php
    $tipoUtente = $_SESSION['tipoUtente'];
    $email = $_SESSION['email'];
    $titolo = $_POST['titolo'];
    $testo = $_POST['testo'];
    $recipiente = $_POST['recipiente'];
    $test = $_POST['test'];

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "CALL MANDA_MESSAGGIO('$titolo', '$test', '$testo', '$recipiente')";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        echo ("Azione fallita") . $e->getMessage();
        exit();
    }
    if ($tipoUtente == "studente") {
        header("Location: ./student-homepage.php");
        exit();
    } else {
        header("Location: ./professor-homepage.php");
        exit();
    }
    ?>
</body>

</html>