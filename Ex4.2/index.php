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
        <?php
            $query = $pdo->prepare("select Continent from country group by Continent");

            $query->execute();

            $row = $query->fetch();
            while ( $row ) {
                if(isset($_GET[str_replace(" ","_",$row["Continent"])])){
                    echo "<input type='checkbox' name='".$row["Continent"]."' id='".$row["Continent"]."' value='".$row["Continent"]."' checked>\n";
                }else{
                    echo "<input type='checkbox' name='".$row["Continent"]."' id='".$row["Continent"]."' value='".$row["Continent"]."'>\n";
                }
                
                echo "<label for='".$row["Continent"]."'>".$row["Continent"]."</label><br>\n";
                
                $row = $query->fetch();
            }
            ?>
        

        <input type="submit">
    </form>
    <ul>
        <?php
            $continentsSeleccionants = "";

            foreach($_GET as $key => $value){
                $continentsSeleccionants .= "'".str_replace("_"," ",$key)."'".",";
            }

            $continentsSeleccionants = substr($continentsSeleccionants,0,strlen($continentsSeleccionants)-1);


            $query = $pdo->prepare("select Name from country where Continent in ($continentsSeleccionants)");
            $query->execute();

            $row = $query->fetch();
            while ( $row ) {
                echo "<li>".$row["Name"]."</li>";
                $row = $query->fetch();
            }

        ?>
    </ul>
</body>
</html>