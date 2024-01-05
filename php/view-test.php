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
    $testNum = $_POST['page'];
    $email = $_SESSION['email'];

    echo ($testNum . "\r\n");

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        $sql = "SELECT * FROM TEST ORDER BY DataCreazione DESC";
        $result = $pdo->query($sql);

        $index = 1;

        foreach ($result as $row) {
            if ($index == $testNum) {
                $test = $row;
                break;
            } else {
                $index += 1;
                continue;
            }
        }
    } catch (PDOException $e) {
        echo ("Azione fallito") . $e->getMessage();
        exit();
    }

    echo ($test["Titolo"]);
    ?>
</body>

</html>