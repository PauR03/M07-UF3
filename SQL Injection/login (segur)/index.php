<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username"><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password"><br><br>
        <input type="submit">
    </form>
    <?php
        if(isset($_POST)){
            try {
                $hostname = "localhost";
                $dbname = "pruebas";
                $username = "admin";
                $pw = "admin123";
                $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
                } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
                exit;
                }
                
            $query = $pdo->prepare("select username,password from users where username = :user and password = :pass");

            $user = $_POST['username'];
            $pass = sha1($_POST['password']);

            $query->bindParam(':user', $user);
            $query->bindParam(':pass', $pass);


            $query->execute();

            if($row = $query->fetch()){
                echo "Login ;)";
            }else{
                echo "Wrong username or password";
            }

        }
    ?>
</body>
</html>