<?php 
session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, image, price FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion" . $e->getMessage();
    exit();
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product_id;
    header("Location: cart.php");
    exit;
}

if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $key = array_search($item_id, $_SESSION['cart']);
        
        if ($key == false){
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php' ?>
</br>

    <h1>Votre Panier</h1>

    <?php if (!empty($cart_items)): ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom du produit</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cart_items as $item_id): ?> 
                <?php
                
                $product = array_filter($products, function($prod) use ($item_id) {
                    return $prod['id'] == $item_id;
                });
                    $product = array_values($product)[0]; 
                    $total += $product['price'];  
                ?>
                <tr>
                    <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?>€</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="add_to_cart">Ajouter</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                            <button type="submit" name="remove_item">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <p>Total : <?php echo $total; ?>€</p>
        <form method="POST">
            <button type="submit" name="clear_cart">Vider le Panier</button>
        </form>
        <form method="get" action="checkout.php">
            <button type="submit">Finaliser le Panier</button>
        </form>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
        <a href="index.php">Retourner au Catalogue</a>

        <?php include 'footer.php' ?>
</body>
</html>