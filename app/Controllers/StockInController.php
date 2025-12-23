<?php
declare(strict_types=1);
require_once __DIR__ . '/../Helpers/auth.php';

final class StockInController {
  public static function index(PDO $pdo): array {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $pid = (int)($_POST['product_id'] ?? 0);
      $qty = (int)($_POST['qty'] ?? 0);
      if ($pid<=0 || $qty<=0) {
        flash_set('error','Pick product and qty > 0.');
        header('Location: ' . BASE_URL . '/public/index.php?route=stock_in'); exit;
      }

      $pdo->beginTransaction();
      try {
        $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id=?")->execute([$qty,$pid]);
        $pdo->prepare("INSERT INTO stock_movements (product_id,type,qty,note) VALUES (?,?,?,?)")
            ->execute([$pid,'IN',$qty,'Manual stock in']);
        $pdo->commit();
        flash_set('success','Stock added.');
      } catch(Throwable $e){
        $pdo->rollBack();
        flash_set('error','Failed.');
      }
      header('Location: ' . BASE_URL . '/public/index.php?route=stock_in'); exit;
    }

    $products = $pdo->query("SELECT id, sku, name, stock FROM products ORDER BY name ASC")->fetchAll();
    return ['view'=>'stock_in','data'=>compact('products')];
  }
}
