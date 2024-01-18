<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Attributo</title>
    <link rel="stylesheet" href="../styles/signup.css">
</head>

<body>
    <?php
    $nomeTabella = $_POST['nomeTabella'];
    ?>
    <div class="container">
        <form action="../php/add-attribute-2.php" method="post" id="editTabella">
            <div class="container-three">
                <label for="Nome">Nome</label>
                <input type="text" placeholder="Entri Nome" name="nome" required>

                <label for="tipoData">Tipo Data</label>
                <select name="tipoData" id="tipoData" required>
                    <option value="CHAR">CHAR</option>
                    <option value="VARCHAR">VARCHAR</option>
                    <option value="BLOB">BLOB</option>
                    <option value="ENUM">ENUM</option>
                    <option value="TINYINT">TINYINT</option>
                    <option value="BOOL">BOOL</option>
                    <option value="INT">INT</option>
                    <option value="BIGINT">BIGINT</option>
                    <option value="FLOAT">FLOAT</option>
                    <option value="DOUBLE">DOUBLE</option>
                    <option value="DATE">DATE</option>
                    <option value="DATETIME">DATETIME</option>
                </select>

                <label for="primaryKey">Primary Key</label>
                <select name="primaryKey" id="primaryKey" required>
                    <option value="si">Sì</option>
                    <option value="no">No</option>
                </select>

                <input type="hidden" name="nomeTabella" value="<?php echo $nomeTabella; ?>">
            </div>
        </form>

        <button style="margin-top: 10px;" type="submit" form="editTabella" value="Submit">Crea</button>
    </div>
</body>

</html>