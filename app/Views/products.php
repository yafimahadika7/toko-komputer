<?php
declare(strict_types=1);
/** @var array $products */
/** @var array $categories */
$title = 'Products';
$subtitle = 'Manage catalog';
ob_start();
?>
<form method="post" action="<?= BASE_URL ?>/public/index.php?route=products" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-4">
  <input name="sku" required placeholder="SKU"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500">
  <input name="name" required placeholder="Product name"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500 md:col-span-2">
  <select name="category_id"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500">
    <option value="">Category (optional)</option>
    <?php foreach ($categories as $c): ?>
      <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="number" name="price" required min="0" placeholder="Price"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500">
  <div class="md:col-span-5 flex gap-3">
    <input type="number" name="stock" required min="0" placeholder="Initial stock"
      class="flex-1 rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-500">
    <button class="rounded-xl bg-white text-slate-900 px-5 py-3 text-sm font-semibold hover:bg-slate-100">Add</button>
  </div>
</form>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
  <thead class="text-slate-400">
    <tr>
      <th class="text-left py-2">SKU</th>
      <th class="text-left py-2">Name</th>
      <th class="text-left py-2">Category</th>
      <th class="text-right py-2">Price</th>
      <th class="text-right py-2">Stock</th>
    </tr>
  </thead>
  <tbody class="divide-y divide-slate-800/60">
    <?php foreach ($products as $p): ?>
      <tr class="hover:bg-slate-950/40">
        <td class="py-3"><?= htmlspecialchars($p['sku']) ?></td>
        <td class="py-3 font-medium"><?= htmlspecialchars($p['name']) ?></td>
        <td class="py-3 text-slate-300"><?= htmlspecialchars($p['category_name'] ?? '-') ?></td>
        <td class="py-3 text-right">Rp <?= number_format((int)$p['sell_price'],0,',','.') ?></td>
        <td class="py-3 text-right"><?= (int)$p['stock'] ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (empty($products)): ?>
      <tr><td colspan="5" class="py-6 text-center text-slate-400">No products</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</div>
<?php
$body = ob_get_clean();
$actions = null;
require __DIR__ . '/_card.php';
