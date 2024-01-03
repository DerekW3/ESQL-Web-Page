<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../styles/professor-homepage.css">
</head>

<body>
    <div class="header">
        <h3><?php echo ("Ciao, " . $_COOKIE['name']); ?></h3>
        <a href="./messaggi.php"><img id="messaggi" src="https://cdn3.iconfinder.com/data/icons/email-51/48/53-512.png" alt="Simbolo per messaggi"></a>
    </div>
    <div class="content">
        <h3 id="testTitle">Test Disponibili<h3>
                <div class="tests">
                    <?php
                    try {
                        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->exec('SET NAMES "utf8"');
                    } catch (PDOException $e) {
                        echo ("Connessione non riuscita") . $e->getMessage();
                        exit();
                    }

                    try {
                        $sql = "SELECT * FROM TEST";
                        $result = $pdo->query($sql);

                        if ($result->rowCount() == 0) {
                            echo '<div id="none">Nessun Test Disponibile</div>';
                        } else {
                            foreach ($result as $row) {
                                $titolo = $row['Titolo'];
                                $dataCreazione = $row['DataCreazione'];
                                echo
                                "<div class=\"test\">
                                    <div class=\"info\">
                                        <h3 style=\"color: var(--text);\">$titolo</h3>
                                        <h3 style=\"color: var(--text);\">$dataCreazione</h3>
                                    </div>
                                    <a href=\"../index.html\"><button id=\"accediTest\">Accedi</button></a>
                                </div>";
                            }
                        }
                    } catch (PDOException $e) {
                        echo ("Query Fallito") . $e->getMessage();
                        exit();
                    }
                    ?>
                </div>
    </div>
</body>