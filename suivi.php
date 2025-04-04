<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
include "bdd.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les commandes de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM commandes WHERE username = :username ORDER BY date_commande DESC");
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Commande</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php"; ?>
</br>
</br>
</br>
    <main>
        <div class="suivi-container">
            <h1>Suivi de vos commandes</h1>
            <p>Bienvenue sur la page de suivi de vos commandes. Voici l'état actuel de vos commandes.</p>

            <?php if ($commandes): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Commande</th>
                            <th>Date de Commande</th>
                            <th>Statut</th>
                            <th>Montant Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($commande['id_commande']); ?></td>
                                <td><?php echo htmlspecialchars($commande['date_commande']); ?></td>
                                <td><?php echo htmlspecialchars($commande['statut']); ?></td>
                                <td><?php echo htmlspecialchars($commande['montant_total']); ?> €</td>
                                <td>
                                    <a href="details_commande.php?id=<?php echo $commande['id_commande']; ?>">Voir les détails</a>
                                    <!-- Optionnel : Ajouter un bouton pour annuler ou modifier -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune commande trouvée.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
