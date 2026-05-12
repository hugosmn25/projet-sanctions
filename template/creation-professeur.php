<?php
$errors = $errors ?? [];
$values = $values ?? ['nom' => '', 'prenom' => '', 'matiere' => ''];

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function has_error($errors, $key){ return !empty($errors[$key]); }

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 mb-6 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-4">
        <span class="material-icons text-5xl">school</span>
        Créer un professeur
      </h1>
      <p class="mt-2 text-blue-100/90">Ajoutez un nouveau professeur à votre établissement</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Informations du professeur</h2>
        <p class="mt-1 text-sm text-gray-500">Renseignez les informations nécessaires pour créer le professeur</p>
      </div>

      <form method="post" action="?action=create_professeur" class="p-6 space-y-6" novalidate>
        <?php if (!empty($errors['general'])): ?>
          <div class="text-red-700 bg-red-100 p-3 rounded"><?php echo e($errors['general']); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
            <input
              name="nom"
              type="text"
              placeholder="Ex: Dupont"
              value="<?php echo e($values['nom'] ?? ''); ?>"
              class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'nom') ? 'border-red-500' : 'border-gray-200'; ?>"/>
            <?php if (has_error($errors,'nom')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['nom']); ?></p>
            <?php endif; ?>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Prénom <span class="text-red-500">*</span></label>
            <input
              name="prenom"
              type="text"
              placeholder="Ex: Marie"
              value="<?php echo e($values['prenom'] ?? ''); ?>"
              class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'prenom') ? 'border-red-500' : 'border-gray-200'; ?>"/>
            <?php if (has_error($errors,'prenom')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['prenom']); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Matière <span class="text-red-500">*</span></label>
          <input
            name="matiere"
            type="text"
            placeholder="Ex: Mathématiques, Français, Histoire-Géographie"
            value="<?php echo e($values['matiere'] ?? ''); ?>"
            class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'matiere') ? 'border-red-500' : 'border-gray-200'; ?>"/>
          <?php if (has_error($errors,'matiere')): ?>
            <p class="mt-1 text-sm text-red-600"><?php echo e($errors['matiere']); ?></p>
          <?php endif; ?>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
          Tous les champs suivis de <span class="text-red-500">*</span> sont obligatoires.
        </div>

        <div class="flex items-center justify-between gap-4 mt-2">
          <a href="?action=liste-professeurs" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
            <span class="material-icons">arrow_back</span> Retour à la liste
          </a>

          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
            <span class="material-icons">person_add</span> Créer le professeur
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Créer un professeur';
require __DIR__ . '/layout.php';