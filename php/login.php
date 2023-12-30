<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
</head>

<body>
    <?php
        $email=$_POST["emailUtente"];
        $password=$_POST["password"];

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "ESQLadmin", "esqladminpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException) {
            echo("Connessione non riuscita");
            exit();
        }

        try {
            $sql="SELECT * FROM UTENTI WHERE Email = '$email'";
            $result=$pdo->query($sql);
            if ($result->rowCount() == 0) {
                header("Location: ../webpages/select-type.html");
                exit();
            } else {
                foreach($result as $row) {
                    $name=$row['Nome'];
                    $cognome=$row['Cognome'];
                }
                setcookie("name", $name, time() + 3.6e6);
                setcookie("cognome", $cognome, time() + 3.6e6);
                
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                // TODO: Redirect to the main page based on type
            }
        } catch (PDOException) {
            exit();
        }
    ?>
</body>