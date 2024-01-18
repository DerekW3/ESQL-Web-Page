<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dando Esame</title>
    <link rel="stylesheet" href="../styles/professor-homepage.css">
</head>

<body>
    <div class="header">
        <h3><?php echo ("Ciao, " . $_COOKIE['name'] . ". Buona fortuna!"); ?></h3>
    </div>
    <div class="content">
        <div class="quesiti">
            <?php
            if (isset($_COOKIE['page'])) {
                $testNum = $_COOKIE['page'];
            } else {
                $testNum = $_POST['page'];
                setcookie('page', $testNum, time() + 3.6e6);
            }
            if (isset($_COOKIE['tipoQuesito'])) {
                setcookie('tipoQuesito', "", time() - 3600);
            }
            if (isset($_COOKIE['numeroQuesito'])) {
                setcookie('numeroQuesito', "", time() - 3600);
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

            $titoloTest = $test['Titolo'];
            echo ("<h3 id=\"title\"> $titoloTest </h3>");
            setcookie("titoloTest", $titoloTest, time() + 3.6e6);

            try {
                $sql = "SELECT * FROM QUESITI WHERE TitoloTest LIKE '$titoloTest' ORDER BY Numero";
                $result = $pdo->query($sql);

                foreach ($result as $row) {
                    $livelloDifficolta = $row['LivelloDifficolta'];
                    $descrizione = $row['Descrizione'];
                    $num = $row['Numero'];

                    echo
                    "<div class=\"quesito\">
                        <div id=\"info\" style=\"margin-right: auto;\">
                            <h3 style=\"color: var(--text);\">$num)   $livelloDifficolta</h3>
                            <p style=\"color: var(--text);\">$descrizione</p>
                        </div>
                        <form action=\"./question-response.php\" method=post>
                            <input type=\"hidden\" name=numeroQuesito value=\"$num\">
                            <input type=\"hidden\" name=titoloTest value=\"$titoloTest\">
                            <input type=\"hidden\" name=page value=\"$testNum\">
                            <button type=\"submit\">Accedi</button>
                        </form>
                    </div>";
                }
            } catch (PDOException $e) {
                echo ("Azione fallito") . $e->getMessage();
                exit();
            }
            ?>
        </div>
    </div>
</body>

</html>