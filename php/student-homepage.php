<?php
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../styles/student-homepage.css">
</head>
<body>
    <div><?php echo("Ciao, " . $_COOKIE['name']); ?></div>
    <div class="content">
        <div>Messaggi</div>
        <div>Esami</div>
        <div></div>
    </div>
</body>
</html>