<?php
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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body> 
    <h2>Login</h2>
    <form action="index.php" method="post">
        <label for="lo-username">Username: </label>
        <input type="text" name="lo-username" id="lo-username"><br><br>
        <label for="lo-password">Password: </label>
        <input type="password" name="lo-password" id="lo-password"><br><br>
        <input type="submit" value="Login">
    </form>
    <?php
        if(isset($_POST) && $_POST != null && array_key_exists("lo-username",$_POST)){
                
            $query = $pdo->prepare("select username,password from users where username = :user and password = :pass");

            $user = $_POST['lo-username'];
            $pass = sha1($_POST['lo-password']);

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
    <br><hr>
    <h2>Register</h2>
    <form action="index.php" method="post">
        <label for="re-username">Username: </label>
        <input type="text" name="re-username" id="re-username"><br><br>
        <label for="re-password">Password: </label>
        <input type="password" name="re-password" id="re-password"><br><br>
        <label for="conf-re-password">Confirm password: </label>
        <input type="password" name="conf-re-password" id="conf-re-password"><br><br>
        <input type="submit" value="Register">
    </form>
    <?php
    if (isset($_POST) && $_POST != null && array_key_exists("re-username", $_POST)) {
        if($_POST['re-password'] == $_POST['conf-re-password'] && $_POST['re-password'] != null){
            
            $query = $pdo->prepare("insert into users(username,password) values(:user,:pass)");

            $user = $_POST['re-username'];
            $pass = sha1($_POST['re-password']);

            $query->bindParam(':user', $user);
            $query->bindParam(':pass', $pass);


            $query->execute();

            $exit = "Registered user :)";
            


        }else if($_POST['re-password'] == null || $_POST['conf-re-password'] == null){
            $exit = "Please complete all fields";
        }else{
            $exit = "Passwords do not match";
        }
        echo $exit;
    }
    ?>
</body>
</html>