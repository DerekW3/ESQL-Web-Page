<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Foreign Key</title>
    <link rel="stylesheet" href="../styles/signup.css">
</head>

<body>
    <?php
    $nome = $_POST['nomeTabella'];

    if (isset($_POST['SubmitButton'])) {
        $email = $_SESSION['email'];
        $attributes = $_POST['attributes'];
        $tabella = $_POST['tabella'];
        $altri = $_POST['altri'];

        try {
            $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch (PDOException $e) {
            echo ("Connessione non riuscita") . $e->getMessage();
            exit();
        }

        try {
            $sql = "ALTER TABLE " . $nome . " ADD CONSTRAINT FOREIGN KEY (" . $attributes . ") REFERENCES " . $tabella . "(" . $altri . ")";
            echo $sql;
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
                <label for="primaryKey">Attributes</label>
                <input type="text" name="attributes" required>

                <label for="references">References</label>

                <label for="tabella">Tabella</label>
                <input type="text" name="tabella" required>

                <label for="altri">Altri Attributi</label>
                <input type="text" name="altri" required>
            </div>

            <input type="hidden" name="nomeTabella" value=<?php echo $nome; ?>>
            <input type="submit" name="SubmitButton">
        </form>
    </div>
</body>

</html>