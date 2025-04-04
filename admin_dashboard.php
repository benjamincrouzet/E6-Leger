<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include "bdd.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_NUM);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de board Admin</title>
    <link rel="stylesheet" href="style_admin.css">
</head>
<body class="admin-page">
    <h1>Bienvenue Monsieur</h1>

    <h2>Liste des tables dans notre base de données "<?php echo $dbname; ?>"</h2>

    <?php 
        if ($tables) {
            foreach ($tables as $table) {
                $tableName = $table[0];
                echo "<h3>Table : $tableName</h3>";
                
                $stmt = $conn->query("SELECT * FROM $tableName");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($rows) {
                    echo "<table>";
                    echo "<tr>";
                    foreach (array_keys($rows[0]) as $column) {
                        echo "<th>$column</th>";
                    }
                    echo "<th>Actions</th>";
                    echo "</tr>";

                    foreach ($rows as $row) {
                        $idColumn = array_keys($rows[0])[0];

                        if ($row[$idColumn] == 0) {
                            continue;
                        }

                        echo "<tr>";
                        foreach ($row as $data) {
                            echo "<td>$data</td>";
                        }
                        echo "<td class='actions'>";
                        echo "<a href='edit.php?table=$tableName&id={$row[$idColumn]}'>Modifier</a>";
                        echo "<br>";
                        echo "<a href='delete.php?table=$tableName&id={$row[$idColumn]}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet enregistrement ?\"):'>Supprimer</a>";
                        echo "</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Aucune donnée disponible dans la table $tablename. </p>";
                }
                echo "<div class='add-record'><a href='create.php?table=$dbname'>Ajouter un nouvel enregistrement</a></div>";
            }
        } else {
            echo "<p>Aucune table trouvée dans la base de données.</p>";
        }
    ?>

    <form action="logout.php">
        <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
    </form>
</body>
</html>