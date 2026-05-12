<?php
$professors = $professors ?? [];
$created = $created ?? null;

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-4xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-6 mb-6">
      <h1 class="text-2xl md:text-3xl font-extrabold flex items-center gap-3">
        <span class="material-icons text-4xl">people</span>
        Liste des professeurs
      </h1>
      <p class="mt-1 text-blue-100/90">Tous les professeurs enregistrés dans le système</p>
    </div>

    <?php if (!empty($created)): ?>
      <div class="mb-4 text-green-800 bg-green-50 p-3 rounded">Professeur créé avec succès.</div>
    <?php endif; ?>

    <div class="mb-4 flex items-center justify-between gap-4">
      <a href="?action=create_professeur" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
        <span class="material-icons">person_add</span> Créer un professeur
      </a>
      <a href="?action=dashboard" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
        <span class="material-icons">arrow_back</span> Retour au tableau de bord
      </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <?php if (empty($professors)): ?>
        <div class="p-6">
          <p class="text-gray-600">Aucun professeur enregistré pour le moment.</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              <?php foreach ($professors as $p): ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($p['nom'] ?? '') ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($p['prenom'] ?? '') ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= e($p['matiere'] ?? '') ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= e($p['created_at'] ?? '') ?></td>
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
$title = 'Liste des professeurs';
require __DIR__ . '/layout.php';