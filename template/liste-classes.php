<?php
$classes = $classes ?? [];
$created = $created ?? null;
ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-6xl mx-auto mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold flex items-center gap-3"><span class="material-icons text-4xl">corporate_fare</span> Gestion des classes</h1>
          <p class="mt-2 text-blue-100/90">Gérez les classes de votre établissement</p>
        </div>
        <div class="hidden sm:flex gap-3">
          <a href="?action=create_class" class="inline-flex items-center gap-2 bg-white text-primary px-4 py-2 rounded-lg shadow">+ Créer une classe</a>
          <a href="?action=dashboard" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg">🏠 Tableau de bord</a>
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty($created)): ?>
    <div class="max-w-6xl mx-auto mb-6">
      <div class="bg-green-50 border border-green-100 text-green-800 p-4 rounded-lg">✅ Classe créée avec succès.</div>
    </div>
  <?php endif; ?>

  <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <h2 class="text-lg font-semibold">Liste des classes</h2>
      <a href="?action=create_class" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg shadow">+ Nouvelle classe</a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-white">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom de la classe</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Niveau</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créée le</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          <?php if (empty($classes)): ?>
            <tr><td class="px-6 py-8 text-center text-gray-500" colspan="3">Aucune classe enregistrée</td></tr>
          <?php else: ?>
            <?php foreach($classes as $c): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 flex items-center gap-3">
                  <div class="h-10 w-10 flex items-center justify-center rounded-md bg-blue-50 text-blue-600 font-bold"><?php echo strtoupper(substr($c['name'],0,2)); ?></div>
                  <div><?php echo htmlspecialchars($c['name']); ?></div>
                </td>
                <td class="px-6 py-4">
                  <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full <?php
                    echo $c['level'] === 'BTS' ? 'bg-orange-100 text-orange-700' :
                         ($c['level'] === 'Première' ? 'bg-green-100 text-green-700' :
                         ($c['level'] === 'Terminale' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700'));
                  ?>"><?php echo htmlspecialchars($c['level']); ?></span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 flex items-center gap-2">
                  <span class="material-icons text-base text-gray-400">calendar_today</span>
                  <?php echo htmlspecialchars($c['created_at']); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Liste des classes';
require __DIR__ . '/layout.php';