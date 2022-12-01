<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="get">
        Dime el nombre del pais: <input type="text" name="pais">
        <input type="submit" value="Enviar">
    </form>
    <ul>
    <?php
        if(isset($_GET['pais'])){
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

                $query = $pdo->prepare("select Name,Language,IsOfficial,Percentage from country co inner join countrylanguage cl on co.Code = cl.CountryCode where co.Name like '%".$_GET['pais']."%' ");

                $query->execute();

                $row = $query->fetch();
                while ( $row ) {
                    if($row["IsOfficial"] == "F"){
                $row["IsOfficial"] = "No es oficial";
                    }else{
                        $row["IsOfficial"] = "Es oficial";
                    }
                    echo "<li><strong>". $row['Name'] ."</strong></li>\n";

                    echo "<ul>\n<li>". $row["Language"] ."</li>";
                    echo "<li>". $row["IsOfficial"] ."</li>";
                    echo "<li>". $row["Percentage"] ."% </li>\n</ul>";

                    $nombrePais = $row["Name"];
                    $row = $query->fetch();
                }

        }
    ?>
    </ul>
</body>
</html>