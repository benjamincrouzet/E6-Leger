<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php" ?>
    </br>
    <header>
        <div class="header-container">
            <h2>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?> ! &nbsp;&nbsp;</h2>
        </div>
    </header>
    <main>
        <div class="intro-container">
            <p>Nous sommes ravis de vous voir ici. Vous pouvez consulter nos produits, ajouter des articles à votre panier, et profiter des nombreuses fonctionnalités de notre site.</p>
        </div>

        <!-- Section avec des icônes ou des produits populaires -->
        <div class="features-container">
            <div class="feature-card">
                <a href="index.php"><h4>Explorez nos produits</h4></a>
                <p>Parcourez notre catalogue pour découvrir une large gamme de produits.</p>
            </div>
            <div class="feature-card">
                <a href="cart.php"><h4>Consultez votre panier</h4></a>
                <p>Ajoutez vos produits préférés à votre panier et passez à la caisse en toute simplicité.</p>
            </div>
            <div class="feature-card">
                <a href="suivi.php"><h4>Suivi de commande</h4></a>
                <p>Suivez vos commandes et soyez informé de leur statut à chaque étape.</p>
            </div>
        </div>

        <!-- Section avec produits populaires ou notifications -->
        <div class="product-notifications">
            <h3>Produits restant</h3>
            <div class="product-list">
                <!-- Exemple de produits populaires (en fonction des données de ta base de données) -->
                <div class="product-item">
                    <img src="assets/sao.jpg">
                    <p>Sword Art Online</p>
                    <a href="index.php">Voir le produit</a>
                </div>
                <div class="product-item">
                    <img src="assets/op.jpg">
                    <p>One Piece</p>
                    <a href="index.php">Voir le produit</a>
                </div>
                <div class="product-item">
                    <img src="assets/snk.jpg">
                    <p>Attaque Des Titans</p>
                    <a href="index.php">Voir le produit</a>
                </div>
            </div>
            <form action="logout.php">
                <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
            </form>
        </div>
    </main>
    <?php include "footer.php" ?>
</body>
</html>
