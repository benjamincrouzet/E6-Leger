<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <img src="assets/logo_manga.jpg" alt="Logo" class="navbar-logo">
        </div>

        <div class="search-bar">
            <form action="search.php" method="get" style="display: flex; align-items: center;">
                <input type="text" name="query" placeholder="Rechercher" required>
                <button type="submit" style="background: none; border: none; padding: 0; margin-left: 5px;">
                </button>
            </form>
        </div>

        <div class="navbar-right">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="accueil.php">Accueil</a>
                <a href="index.php">Catalogue</a>
                <a href="cart.php">Panier</a>
                <a href="connexion.php">Connexion</a> 
                <a href="inscription.php">Inscription</a>
            <?php else:?>
                <a href="accueil.php">Accueil</a>
                <a href="index.php">Catalogue</a>
                <a href="cart.php">Panier</a>
                <a href="compte.php">Profil</a>    
                <a href="logout.php">Deconnexion</a>
            <?php endif;?>
        </div>
    </div>
</body>
</html>