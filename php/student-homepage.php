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
    <div class="header">
        <h3><?php echo $_SESSION['email']; ?></h3>
        <h3>Messaggi</h3>
        <h3>Voti</h3>
        <h3>Gatti</h3>
    </div>
    <div class="content">
        
    </div>
</body>
</html>