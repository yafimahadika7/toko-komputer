<?php
declare(strict_types=1);
/** @var array $products */
$title='Add Stock'; $subtitle='Kasir & Admin';
ob_start();
?>
<form method="post" class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
  <select name="product_id" required class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
    <option value="">Select product</option>
    <?php foreach($products as $p): ?>
      <option value="<?= (int)$p['id'] ?>">
        <?= htmlspecialchars($p['name']) ?> (<?= (int)$p['stock'] ?>)
      </option>
    <?php endforeach; ?>
  </select>
  <input type="number" name="qty" min="1" required placeholder="Qty"
    class="rounded-xl bg-slate-950 border border-slate-800/70 px-4 py-3 text-sm">
  <button class="rounded-xl bg-white text-slate-900 px-5 py-3 text-sm font-semibold hover:bg-slate-100">Add</button>
</form>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
  <thead class="text-slate-400"><tr><th class="text-left py-2">SKU</th><th class="text-left py-2">Name</th><th class="text-right py-2">Stock</th></tr></thead>
  <tbody class="divide-y divide-slate-800/60">
    <?php foreach($products as $p): ?>
      <tr class="hover:bg-slate-950/40">
        <td class="py-3"><?= htmlspecialchars($p['sku']) ?></td>
        <td class="py-3 font-medium"><?= htmlspecialchars($p['name']) ?></td>
        <td class="py-3 text-right"><?= (int)$p['stock'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php
$body=ob_get_clean(); $actions=null; require __DIR__.'/_card.php';
