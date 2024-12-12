<?php
require_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);

    if ($product_id <= 0) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Invalid product ID!";
        header('Location: ../index.php?page=products');
        exit;
    }

    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    if ($image) {

        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($image);


        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

        } else {
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = "Failed to upload image!";
            header('Location: ./index.php?page=products');
            exit;
        }
    } else {
        $query = "SELECT image FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch();
        $image = $product['image'];
    }

    $query = "UPDATE products SET title = :title, price = :price, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':title' => $title, ':price' => $price, ':image' => $image, ':id' => $product_id]);

    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Product updated successfully!";
    header('Location: ../index.php?page=products');
    exit;
}
