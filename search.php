<?php 
include 'bdd.php';

if (isset($_GET['query'])) {
    $search = htmlspecialchars($_GET['query']);
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname",$dbusername,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("Erreur de connexion : " . $e->getMessage());
}
$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query");
$stmt->execute(['query' => '%' . $search . "%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Résultats pour "<?php echo htmlspecialchars($search)?>"</h1>
    <div class="product-list">
        <?php if (!empty($results)): ?>
            <?php foreach($results as $product): ?>  
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($product['image']) ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" class="product-img">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p>Prix :€<?php echo htmlspecialchars($product['price']); ?></p>
                <form method="POST" action="add_to_cart.php">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <button type="submit" name="add_to_cart">Ajouter au panier </button>
                </form>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun Résultats trouvé pour votre recherche.</p>
            <?php endif; ?>
    </div>
    <?php include 'footer.php' ?>
</body>
</body>
</html>