<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //Conexio a la db
        try {
            $hostname = "localhost";
            $dbname = "world";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
            } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
            }
    ?>
    <form action="index.php" method="get">
        <select name="continent">
            <?php
                
                $query = $pdo->prepare("select Continent from country group by Continent");

                $query->execute();

                $row = $query->fetch();
                while ( $row ) {
                    echo "<option value='".$row["Continent"]."'>".$row['Continent']."</option>\n";
                    $row = $query->fetch();
                }
            ?>
        </select>
        <input type="submit">
    </form>

    <ul>
        <?php
            if(isset($_GET['continent'])){
                
                $query = $pdo->prepare("select Name from country where Continent = '". $_GET['continent'] ."'");
                $query->execute();

                $row = $query->fetch();
                while ( $row ) {
                    echo "<li>".$row["Name"]."</li>";
                    $row = $query->fetch();
                }

                
            }
        ?>
    </ul>
</body>
</html>