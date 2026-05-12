<?php
$students = $students ?? [];
$created = $created ?? null;
ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-6xl mx-auto mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold flex items-center gap-3"><span class="material-icons text-4xl">groups</span> Gestion des élèves</h1>
          <p class="mt-2 text-blue-100/90">Gérez les élèves de votre établissement</p>
        </div>
        <div class="hidden sm:flex gap-3">
          <a href="?action=create_student" class="inline-flex items-center gap-2 bg-white text-primary px-4 py-2 rounded-lg shadow">+ Créer un élève</a>
          <a href="?action=dashboard" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg">🏠 Tableau de bord</a>
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty($created)): ?>
    <div class="max-w-6xl mx-auto mb-6">
      <div class="bg-green-50 border border-green-100 text-green-800 p-4 rounded-lg">✅ Élève créé avec succès.</div>
    </div>
  <?php endif; ?>

  <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <h2 class="text-lg font-semibold">Liste des élèves</h2>
      <a href="?action=create_student" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg shadow">+ Nouvel élève</a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-white">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom de l'élève</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Niveau</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de naissance</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          <?php if (empty($students)): ?>
            <tr><td class="px-6 py-8 text-center text-gray-500" colspan="4">Aucun élève enregistré pour le moment.</td></tr>
          <?php else: ?>
            <?php foreach($students as $s): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 flex items-center gap-3">
                  <div class="h-10 w-10 flex items-center justify-center rounded-md bg-blue-50 text-blue-600 font-bold">
                    <?php
                      $p = explode(' ', $s['nom'] ?? '');
                      $initials = '';
                      foreach(array_slice($p,0,2) as $_p) $initials .= strtoupper(substr($_p,0,1));
                      echo $initials;
                    ?>
                  </div>
                  <div class="font-medium text-gray-800"><?php echo htmlspecialchars(($s['nom'] ?? '') . ' ' . ($s['prenom'] ?? '')); ?></div>
                </td>
                <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($s['class_name'] ?? ''); ?></td>
                <td class="px-6 py-4">
                  <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full <?php
                    echo ($s['level'] ?? '') === 'Première' ? 'bg-green-100 text-green-700' : (($s['level'] ?? '') === 'Seconde' ? 'bg-indigo-100 text-indigo-700' : 'bg-purple-100 text-purple-700');
                  ?>"><?php echo htmlspecialchars($s['level'] ?? ''); ?></span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 flex items-center gap-2">
                  <span class="material-icons text-base text-gray-400">calendar_today</span>
                    <?php echo htmlspecialchars($s['date_naissance'] ?? ''); ?>
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
$title = 'Liste des élèves';
require __DIR__ . '/layout.php';