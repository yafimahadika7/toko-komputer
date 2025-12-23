<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Helpers/auth.php';

final class ProductController {
  public static function index(PDO $pdo): array {
    // create
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $sku = trim($_POST['sku'] ?? '');
      $name = trim($_POST['name'] ?? '');
      $categoryId = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
      $price = (int)($_POST['price'] ?? 0);
      $stock = (int)($_POST['stock'] ?? 0);

      if ($sku === '' || $name === '' || $price < 0 || $stock < 0) {
        flash_set('error', 'Invalid product input.');
        header('Location: ' . BASE_URL . '/public/index.php?route=products'); exit;
      }

      $st = $pdo->prepare("INSERT INTO products (sku, name, category_id, sell_price, stock) VALUES (?,?,?,?,?)");
      $st->execute([$sku, $name, $categoryId, $price, $stock]);

      if ($stock > 0) {
        $pid = (int)$pdo->lastInsertId();
        $mv = $pdo->prepare("INSERT INTO stock_movements (product_id, type, qty, note) VALUES (?,?,?,?)");
        $mv->execute([$pid, 'IN', $stock, 'Initial stock']);
      }

      flash_set('success', 'Product created.');
      header('Location: ' . BASE_URL . '/public/index.php?route=products'); exit;
    }

    $categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll();
    $products = $pdo->query("
      SELECT p.*, c.name AS category_name
      FROM products p
      LEFT JOIN categories c ON c.id = p.category_id
      ORDER BY p.id DESC
    ")->fetchAll();

    return ['view' => 'products', 'data' => compact('products','categories')];
  }
}
