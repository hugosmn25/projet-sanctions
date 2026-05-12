<?php
$classes = $classes ?? [];
$errors = $errors ?? [];
$values = $values ?? ['nom'=>'','prenom'=>'','date_naissance'=>'','classe_id'=>''];

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function has_error($errors, $key){ return !empty($errors[$key]); }
ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 mb-6 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-4"><span class="material-icons text-5xl">person_add</span> Créer un élève</h1>
      <p class="mt-2 text-blue-100/90">Ajoutez un nouvel élève à votre établissement</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Informations de l'élève</h2>
        <p class="mt-1 text-sm text-gray-500">Renseignez les informations nécessaires pour créer l'élève</p>
      </div>

      <form method="post" action="?action=create_student" class="p-6 space-y-6">
        <?php if (!empty($errors['general'])): ?>
          <div class="text-red-700 bg-red-100 p-3 rounded"><?php echo e($errors['general']); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
            <input
              name="nom"
              type="text"
              placeholder="Ex: Martin"
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
              placeholder="Ex: Jean"
              value="<?php echo e($values['prenom'] ?? ''); ?>"
              class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'prenom') ? 'border-red-500' : 'border-gray-200'; ?>"/>
            <?php if (has_error($errors,'prenom')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['prenom']); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Date de naissance <span class="text-red-500">*</span></label>
          <div class="relative mt-2">
            <input
              name="date_naissance"
              type="text"
              placeholder="jj/mm/aaaa"
              value="<?php echo e($values['date_naissance'] ?? ''); ?>"
              class="block w-full rounded-lg border px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'date_naissance') ? 'border-red-500' : 'border-gray-200'; ?>" />
            <span class="material-icons absolute right-3 top-3 text-gray-400">calendar_today</span>
          </div>
          <p class="mt-2 text-xs text-gray-500">Format : JJ/MM/AAAA</p>
          <?php if (has_error($errors,'date_naissance')): ?>
            <p class="mt-1 text-sm text-red-600"><?php echo e($errors['date_naissance']); ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Classe <span class="text-red-500">*</span></label>
          <select
            name="classe_id"
            class="mt-2 block w-full rounded-lg border px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'classe_id') ? 'border-red-500' : 'border-gray-200'; ?>">
            <option value="0">Sélectionnez une classe</option>
            <?php foreach($classes as $c): ?>
              <option value="<?php echo e($c['id']); ?>" <?php if (!empty($values['classe_id']) && $values['classe_id'] == $c['id']) echo 'selected'; ?>><?php echo e($c['name'] ?? $c['nom'] ?? ''); ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (has_error($errors,'classe_id')): ?>
            <p class="mt-1 text-sm text-red-600"><?php echo e($errors['classe_id']); ?></p>
          <?php endif; ?>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
          Tous les champs suivis de <span class="text-red-500">*</span> sont obligatoires.
        </div>

        <div class="flex items-center justify-between gap-4 mt-2">
          <a href="?action=liste-eleves" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
            <span class="material-icons">arrow_back</span> Retour à la liste
          </a>

          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
            <span class="material-icons">person_add</span> Créer l'élève
          </button>
        </div>
      </form>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-lg p-4">
      <div class="flex items-start gap-3">
        <div class="text-blue-500 mt-1"><span class="material-icons">info</span></div>
        <div>
          <h4 class="font-medium text-blue-800">💡 Conseil</h4>
          <p class="text-sm text-blue-700/90 mt-1">Une fois l'élève créé, vous pourrez lui associer des sanctions et suivre son parcours dans l'établissement.</p>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Créer un élève';
require __DIR__ . '/layout.php';