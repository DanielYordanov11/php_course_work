<?php
    $product_id = intval($_GET['product_id'] ?? 0);

    if ($product_id <= 0) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Invalid product ID!";
        header('Location: ./index.php?page=products');
        exit;
    }

    $query = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $product_id]);
    $product = $stmt->fetch();

?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="/upr9/handlers/handle_edit_product.php" enctype="multipart/form-data">
    <h3 class="text-center">Edit Product</h3>
    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($product['title']) ?>">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']) ?>">
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <div class="mb-3">
        <?php if ($product['image']): ?>
            <img src="./uploads/<?php echo htmlspecialchars($product['image']) ?>" alt="<?php echo htmlspecialchars($product['title']) ?>" class="img-thumbnail">
        <?php endif; ?>
    </div>
    <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
    <button type="submit" class="btn btn-success mx-auto">Save changes</button>
</form>
