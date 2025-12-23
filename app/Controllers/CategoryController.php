<?php
declare(strict_types=1);
require_once __DIR__ . '/../Helpers/auth.php';

final class CategoryController {
  public static function index(PDO $pdo): array {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name'] ?? '');
      if ($name === '') {
        flash_set('error', 'Category name is required.');
        header('Location: ' . BASE_URL . '/public/index.php?route=categories'); exit;
      }
      $st = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
      $st->execute([$name]);
      flash_set('success', 'Category created.');
      header('Location: ' . BASE_URL . '/public/index.php?route=categories'); exit;
    }

    $categories = $pdo->query("SELECT id, name FROM categories ORDER BY id DESC")->fetchAll();
    return ['view' => 'categories', 'data' => compact('categories')];
  }
}
