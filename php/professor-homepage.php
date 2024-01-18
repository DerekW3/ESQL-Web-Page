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
        <h3 id="title">Test Disponibili</h3>
        <div class="tests">
            <?php
            if (isset($_COOKIE['titoloTest'])) {
                setcookie('titoloTest', "", time() - 3600);
            }
            if (isset($_COOKIE['numQuesito'])) {
                setcookie('numQuesito', "", time() - 3600);
            }
            if (isset($_COOKIE['page'])) {
                setcookie('page', "", time() - 3600);
            }

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
                $sql = "SELECT * FROM TEST ORDER BY DataCreazione DESC";
                $result = $pdo->query($sql);

                if ($result->rowCount() == 0) {
                    echo '<div id="none">Nessun Test Disponibile</div>';
                } else {
                    $testNum = 1;
                    foreach ($result as $row) {
                        $titolo = $row['Titolo'];
                        $dataCreazione = $row['DataCreazione'];
                        echo
                        "<div class=\"test\">
                                    <div id=\"info\">
                                        <h3 style=\"color: var(--text);\">$titolo</h3>
                                        <h3 style=\"color: var(--text);\">$dataCreazione</h3>
                                    </div>

                                    <form action=\"./add-attribute.php\" method=post>
                                        <input type=\"hidden\" name=page value=\"$testNum\">
                                        <button type=\"submit\">Accedi</button>
                                    </form>
                                </div>";
                        $testNum += 1;
                    }
                }
            } catch (PDOException $e) {
                echo ("Query Fallito") . $e->getMessage();
                exit();
            }
            ?>
        </div>
        <h3 id="title">Azioni Disponibili</h3>
        <div class="azioni">
            <a href="../webpages/create-table-esercizio.html"><button class="azione">Crea Tabella Esercizio</button></a>
            <a href="../webpages/create-test.html"><button class="azione">Crea Nuovo Test</button></a>
        </div>
        <h3 id="title">Tabelle Disponibili</h3>
        <div class="tests">
            <?php
            try {
                $sql = "SELECT * FROM ESERCIZI WHERE EmailDocente LIKE '$email'";
                $result = $pdo->query($sql);

                foreach ($result as $tabella) {
                    $nome = $tabella['Nome'];
                    $dataCreazioneTabella = $tabella['DataCreazione'];
                    echo
                    "<div class=\"test\">
                                    <div id=\"info\">
                                        <h3 style=\"color: var(--text);\">$nome</h3>
                                        <h3 style=\"color: var(--text);\">$dataCreazioneTabella</h3>
                                    </div>

                                    <form action=\"./add-attribute.php\" method=post>
                                        <input type=\"hidden\" name=\"nomeTabella\" value=\"$nome\">
                                        <button type=\"submit\">Aggiungi</button>
                                    </form>
                                </div>";
                }
            } catch (PDOException $e) {
                echo ("Fallito") . $e->getMessage();
                exit();
            }
            ?>
        </div>
    </div>
</body>