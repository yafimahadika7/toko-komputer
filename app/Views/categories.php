<?php
declare(strict_types=1);
/** @var array $categories */
$title = 'Categories';
$subtitle = 'Manage product categories';
ob_start();
?>
<form method="post" action="<?= BASE_URL ?>/public/index.php?route=categories" class="flex flex-col md:flex-row gap-3 mb-4">
  <input name="name" required placeholder="Category name"
    class="flex-1 rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500">
  <button class="rounded-xl bg-white text-slate-900 px-5 py-3 text-sm font-semibold hover:bg-slate-100">Add</button>
</form>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
  <thead class="text-slate-400"><tr><th class="text-left py-2">Name</th></tr></thead>
  <tbody class="divide-y divide-slate-800/60">
    <?php foreach ($categories as $c): ?>
      <tr class="hover:bg-slate-950/40"><td class="py-3 font-medium"><?= htmlspecialchars($c['name']) ?></td></tr>
    <?php endforeach; ?>
    <?php if (empty($categories)): ?>
      <tr><td class="py-6 text-center text-slate-400">No categories</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</div>
<?php
$body = ob_get_clean();
$actions = null;
require __DIR__ . '/_card.php';
