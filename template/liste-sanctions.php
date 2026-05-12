<?php
$sanctions = $sanctions ?? [];
$created = $created ?? null;

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-6xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-6 mb-6">
      <h1 class="text-2xl md:text-3xl font-extrabold flex items-center gap-3">
        <span class="material-icons text-4xl">list_alt</span>
        Liste des sanctions
      </h1>
      <p class="mt-1 text-blue-100/90">Historique des incidents disciplinaires</p>
    </div>

    <?php if (!empty($created)): ?>
      <div class="mb-4 text-green-800 bg-green-50 p-3 rounded">Sanction créée avec succès.</div>
    <?php endif; ?>

    <div class="mb-4 flex items-center justify-between gap-4">
      <a href="?action=create_sanction" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
        <span class="material-icons">add</span> Créer une sanction
      </a>
      <a href="?action=dashboard" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
        <span class="material-icons">arrow_back</span> Retour au tableau de bord
      </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <?php if (empty($sanctions)): ?>
        <div class="p-6">
          <p class="text-gray-600">Aucune sanction enregistrée pour le moment.</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motif</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Professeur</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Élève</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              <?php foreach ($sanctions as $s): ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($s['date'] ?? '') ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= e(mb_strimwidth($s['motif'] ?? '', 0, 120, '...')) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= e($s['type'] ?? '') ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e(($s['professor_nom'] ?? '') . ' ' . ($s['professor_prenom'] ?? '')) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e(($s['student_nom'] ?? '') . ' ' . ($s['student_prenom'] ?? '')) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= e($s['class_name'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Liste des sanctions';
require __DIR__ . '/layout.php';