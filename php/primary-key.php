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
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client('mongodb://127.0.0.1:27017');

    $database = $mongoClient->selectDatabase("ESQL");
    $collection = $database->selectCollection("Logs");

    $nome = $_POST['nomeTabella'];

    if (isset($_POST['SubmitButton'])) {
        $email = $_SESSION['email'];
        $values = $_POST['values'];

        try {
            $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch (PDOException $e) {
            echo ("Connessione non riuscita") . $e->getMessage();
            exit();
        }

        try {
            try {
                $sql = "ALTER TABLE " . $nome . " DROP PRIMARY KEY";
                $result = $pdo->query($sql);

                $event = [
                    "timestamp" => time(),
                    "tipo_event" => "primary_key",
                    "descrizione" => $nome
                ];
        
                $result = $collection->insertOne($event);
            } catch (PDOException) {
            }

            $sql = "ALTER TABLE " . $nome . " ADD PRIMARY KEY (" . $values . ")";
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
                <label for="primaryKey">Primary Key</label>
                <input type="text" name="values" required>
            </div>

            <input type="hidden" name="nomeTabella" value=<?php echo $nome; ?>>
            <input type="submit" name="SubmitButton">
        </form>
    </div>
</body>

</html>