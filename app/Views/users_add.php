<?php
declare(strict_types=1);
/** @var array $users */
$title='Add User'; $subtitle='Admin only';
ob_start();
?>
<form method="post" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
  <input name="name" required placeholder="Name"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
  <input name="username" required placeholder="Username"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
  <input name="password" required placeholder="Password"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
  <select name="role" class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
    <option value="admin">admin</option>
    <option value="kasir" selected>kasir</option>
    <option value="owner">owner</option>
  </select>
  <div class="md:col-span-4">
    <button class="rounded-xl bg-white text-slate-900 px-5 py-3 text-sm font-semibold hover:bg-slate-100">Create</button>
  </div>
</form>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
  <thead class="text-slate-400">
    <tr><th class="text-left py-2">Name</th><th class="text-left py-2">Username</th><th class="text-left py-2">Role</th><th class="text-left py-2">Active</th></tr>
  </thead>
  <tbody class="divide-y divide-slate-800/60">
    <?php foreach($users as $u): ?>
      <tr class="hover:bg-slate-950/40">
        <td class="py-3 font-medium"><?= htmlspecialchars($u['name']) ?></td>
        <td class="py-3 text-slate-300"><?= htmlspecialchars($u['username']) ?></td>
        <td class="py-3"><?= htmlspecialchars($u['role']) ?></td>
        <td class="py-3"><?= (int)$u['is_active'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php
$body=ob_get_clean(); $actions=null; require __DIR__.'/_card.php';
