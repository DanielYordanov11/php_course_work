<?php
require_once('functions.php');
require_once('db.php');

$productId = $_GET['id'] ?? null;

if ($productId) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo '<div class="alert alert-danger">Product not found.</div>';
        exit;
    }
    ?>
    <!-- Single Product View -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo !filter_var($product['image'], FILTER_VALIDATE_URL) ? './uploads/' . $product['image'] : $product['image']; ?>" class="img-fluid" alt="<?php echo $product['title']; ?>">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                <h4 class="text-success mt-3">Price: <?php echo htmlspecialchars($product['price']); ?> USD</h4>
                
                <!-- Button Container -->
                <div class="d-flex flex-column mt-4">
                    <a href="buy.php?product_id=<?php echo $product['id']; ?>" class="btn btn-success mb-2">Buy Now</a>
                    <a href="favourites.php?product_id=<?php echo $product['id']; ?>" class="btn btn-danger mb-2">Add to Favourites</a>
                    <a href="index.php?page=edit_product&product_id=<?php echo $product['id']; ?>" class="btn btn-warning mb-2">Edit Product</a>
                    <a href="?page=products" class="btn btn-secondary mb-2">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
} else {
    // Fetch all products for the product listing
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$products) {
        echo '<div class="alert alert-info">No products available.</div>';
        exit;
    }
    ?>
    <!-- Product List View -->
    <div class="container">
        <h1 class="mt-4">Products</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                    <img src="<?php echo !filter_var($product['image'], FILTER_VALIDATE_URL) ? './uploads/' . $product['image'] : $product['image']; ?>" class="card-img-top" alt="<?php echo $product['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <h6 class="text-success">Price: <?php echo htmlspecialchars($product['price']); ?> USD</h6>
                            <a href="?page=products&id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    
}
?>
