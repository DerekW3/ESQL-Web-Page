<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Primary Key</title>
    <link rel="stylesheet" href="../styles/signup.css">
</head>

<body>
    <?php
    $nome = $_POST['nomeTabella'];

    if (isset($_POST['SubmitButton'])) {
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
            $sql = "SHOW COLUMNS FROM " . $nome . "";
            $result = $pdo->query($sql);
            $attributes = array();
            $values = array();
            foreach ($result as $attribute) {
                $attribute = $attribute['Field'];
                array_push($attributes, $attribute);
                $value = $_POST[$attribute];
                array_push($values, $value);
            }
            $first = $nome . "(" . implode(", ", $attributes) . ")";
            $second = "('" . implode("', '", $values) . "')";
            $sql = "INSERT INTO " . $first . " VALUES " . $second;
            echo $sql;
            $result = $pdo->query($sql);

            $sql = "UPDATE ESERCIZI SET num_righe = num_righe + 1 WHERE Nome LIKE '$nome'";
            $result = $pdo->query($sql);
        } catch (PDOException $e) {
            echo ("Fallito") . $e->getMessage();
            exit();
        }

        header("Location: ./professor-homepage.php");
        exit();
    }
    ?>
    <div class="container">
        <form action="" method="post" id="addPrimary">
            <div class="container-three">
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
                    $sql = "SHOW COLUMNS FROM " . $nome . "";
                    $result = $pdo->query($sql);

                    foreach ($result as $attribute) {
                        $attribute = $attribute['Field'];
                        if ($attribute == "SKIP_ATTRIBUTE") {
                            continue;
                        }
                        echo
                        "<label for=\"$attribute\"> $attribute </label>
                        <input type=\"text\" name=\"$attribute\" placeholder=\"Entri\">";
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit();
                }
                ?>
            </div>

            <input type="hidden" name="nomeTabella" value=<?php echo $nome; ?>>
            <input type="submit" name="SubmitButton">
        </form>
    </div>
</body>

</html>