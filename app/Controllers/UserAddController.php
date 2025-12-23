<?php
declare(strict_types=1);
require_once __DIR__ . '/../Helpers/auth.php';

final class UserAddController {
  public static function index(PDO $pdo): array {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name'] ?? '');
      $username = trim($_POST['username'] ?? '');
      $password = trim($_POST['password'] ?? '');
      $role = $_POST['role'] ?? 'kasir';

      if ($name==='' || $username==='' || $password==='') {
        flash_set('error','All fields required.');
        header('Location: ' . BASE_URL . '/public/index.php?route=users_add'); exit;
      }

      $st = $pdo->prepare("INSERT INTO users (name, username, password_hash, role, is_active) VALUES (?,?,?,?,1)");
      $st->execute([$name, $username, $password, $role]);

      flash_set('success','User created.');
      header('Location: ' . BASE_URL . '/public/index.php?route=users_add'); exit;
    }

    $users = $pdo->query("SELECT id,name,username,role,is_active,created_at FROM users ORDER BY id DESC")->fetchAll();
    return ['view'=>'users_add', 'data'=>compact('users')];
  }
}
