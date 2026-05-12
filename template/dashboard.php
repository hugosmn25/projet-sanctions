<?php
$user = $user ?? null;
$stats = $stats ?? ['total_students' => 0, 'total_classes' => 0, 'total_sanctions' => 0, 'total_professeurs' => 0 ];
ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-10">
  <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 mb-8">
    <div class="max-w-6xl mx-auto text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold flex items-center justify-center gap-4">
        <span class="material-icons text-6xl">school</span>
        Bienvenue, <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?> !
      </h1>
      <p class="mt-3 text-lg text-blue-100/90">Tableau de bord de gestion des sanctions scolaires</p>

      <div class="mt-6 flex flex-wrap justify-center gap-4">
        <a href="#" class="inline-flex items-center gap-2 bg-white text-primary px-4 py-2 rounded-lg shadow hover:shadow-md">
          <span class="material-icons">gavel</span> Gérer les Sanctions
        </a>
        <a href="?action=liste-eleves" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg hover:bg-white/30">
          <span class="material-icons">groups</span> Voir les Élèves
        </a>
        <a href="?action=liste-classes" class="inline-flex items-center gap-2 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg">
          <span class="material-icons">class</span> Gérer les Classes
        </a>
        <a href="?action=logout" class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
          <span class="material-icons">logout</span> Déconnexion
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-6xl mx-auto -mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-400">
      <div class="text-sm text-gray-500">Total Sanctions</div>
      <div class="mt-3 text-2xl font-bold"><?php echo htmlspecialchars($stats['total_sanctions'] ?? 0); ?></div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-green-400">
      <div class="text-sm text-gray-500">Total Élèves</div>
      <div class="mt-3 text-2xl font-bold"><?php echo htmlspecialchars($stats['total_students'] ?? 0); ?></div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-purple-400">
      <div class="text-sm text-gray-500">Total Professeurs</div>
      <div class="mt-3 text-2xl font-bold"><?php echo htmlspecialchars($stats['total_professeurs'] ?? 0); ?></div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-orange-400">
      <div class="text-sm text-gray-500">Total Classes</div>
      <div class="mt-3 text-2xl font-bold"><?php echo htmlspecialchars($stats['total_classes'] ?? 0); ?></div>
    </div>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6">
      <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">⚡ Accès Rapide</h3>
      <div class="space-y-3">
        <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100 shadow-sm" href="?action=create_sanction">
          <div class="w-10 h-10 rounded-md bg-pink-50 flex items-center justify-center text-pink-600">+</div>
          <div>
            <div class="font-medium">Nouvelle Sanction</div>
            <div class="text-sm text-gray-500">Enregistrer un nouvel incident</div>
          </div>
        </a>
        <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100 shadow-sm" href="?action=create_student">
          <div class="w-10 h-10 rounded-md bg-blue-50 flex items-center justify-center text-blue-600">👥</div>
          <div>
            <div class="font-medium">Nouvel Élève</div>
            <div class="text-sm text-gray-500">Ajouter un élève au système</div>
          </div>
        </a>
        <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100 shadow-sm" href="?action=create_professor">
          <div class="w-10 h-10 rounded-md bg-green-50 flex items-center justify-center text-green-600">👩‍🏫</div>
          <div>
            <div class="font-medium">Nouveau Professeur</div>
            <div class="text-sm text-gray-500">Enregistrer un enseignant</div>
          </div>
        </a>
        <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100 shadow-sm" href="?action=create_class">
          <div class="w-10 h-10 rounded-md bg-purple-50 flex items-center justify-center text-purple-600">🏫</div>
          <div>
            <div class="font-medium">Nouvelle Classe</div>
            <div class="text-sm text-gray-500">Créer une nouvelle classe</div>
          </div>
        </a>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h3 class="text-lg font-semibold mb-4 flex items-center gap-2"><span class="material-icons">person</span> Informations Utilisateur</h3>
      <div class="space-y-4">
        <div class="rounded-lg bg-gray-50 p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">👤</div>
            <div class="text-sm text-gray-600">Nom complet</div>
          </div>
          <div class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></div>
        </div>
        <div class="rounded-lg bg-gray-50 p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600">✉️</div>
            <div class="text-sm text-gray-600">Email</div>
          </div>
          <div class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($user['email'] ?? ($_SESSION['email'] ?? '')); ?></div>
        </div>
        <div class="rounded-lg bg-gray-50 p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">🏷️</div>
            <div class="text-sm text-gray-600">Service</div>
          </div>
          <div class="text-sm font-medium text-purple-600">Vie Scolaire</div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-6xl mx-auto bg-gradient-to-r from-blue-50 to-white rounded-xl p-6 shadow-inner">
    <h2 class="text-center text-xl font-bold mb-6">🚀 Guide de Démarrage Rapide</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
      <div>
        <div class="mx-auto w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3">1</div>
        <h4 class="font-semibold">Configurez les Classes</h4>
        <p class="text-sm text-gray-600">Créez les classes de votre établissement pour organiser les élèves</p>
      </div>
      <div>
        <div class="mx-auto w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3">2</div>
        <h4 class="font-semibold">Ajoutez les Élèves</h4>
        <p class="text-sm text-gray-600">Enregistrez les élèves et associez-les à leurs classes respectives</p>
      </div>
      <div>
        <div class="mx-auto w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3">3</div>
        <h4 class="font-semibold">Gérez les Sanctions</h4>
        <p class="text-sm text-gray-600">Enregistrez et suivez les sanctions des élèves de manière efficace</p>
      </div>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Tableau de bord';
require __DIR__ . '/layout.php';