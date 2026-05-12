<?php
$errors = $errors ?? [];
$values = $values ?? ['name'=>'','class-name'=>'','level'=>''];

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/**
 * Récupère la première valeur non vide parmi une liste de clés dans $values.
 * Utile pour supporter soit 'class-name' soit 'name' selon l'implémentation du controller.
 */
function get_value(array $values, array $keys, $default = '') {
    foreach ($keys as $k) {
        if (isset($values[$k]) && $values[$k] !== '') return $values[$k];
    }
    return $default;
}

/**
 * Teste si une ou plusieurs clés d'erreurs sont présentes.
 */
function has_error_keys(array $errors, array $keys): bool {
    foreach ($keys as $k) {
        if (!empty($errors[$k])) return true;
    }
    return false;
}

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 mb-6 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-3"><span class="material-icons text-5xl">add</span> Créer une classe</h1>
      <p class="mt-2 text-blue-100/90">Ajoutez une nouvelle classe à votre établissement</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Informations de la classe</h2>
        <p class="mt-1 text-sm text-gray-500">Renseignez les informations nécessaires pour créer la classe</p>
      </div>

      <form method="post" action="?action=create_class" class="p-6 space-y-6">
        <?php if (!empty($errors['general'])): ?>
          <div class="text-red-700 bg-red-100 p-3 rounded"><?php echo e($errors['general']); ?></div>
        <?php endif; ?>

        <div>
          <label for="class-name" class="block text-sm font-medium text-gray-700">Nom de la classe <span class="text-red-500">*</span></label>
          <?php $nameError = has_error_keys($errors, ['class-name','name']); ?>
          <input
            id="class-name"
            name="class-name"
            type="text"
            placeholder="Ex: Terminale S1, Première ES2, Seconde A"
            value="<?php echo e(get_value($values, ['class-name','name'])); ?>"
            class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo $nameError ? 'border-red-500' : 'border-gray-200'; ?>" />
          <?php if ($nameError): ?>
            <p class="mt-1 text-sm text-red-600">
              <?php
                // Affiche le message d'erreur prioritaire (class-name puis name)
                if (!empty($errors['class-name'])) echo e($errors['class-name']);
                elseif (!empty($errors['name'])) echo e($errors['name']);
              ?>
            </p>
          <?php endif; ?>
        </div>

        <div>
          <label for="level" class="block text-sm font-medium text-gray-700">Niveau <span class="text-red-500">*</span></label>
          <?php $levelError = has_error_keys($errors, ['level']); ?>
          <select
            id="level"
            name="level"
            class="mt-2 block w-full rounded-lg border px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary <?php echo $levelError ? 'border-red-500' : 'border-gray-200'; ?>">
            <option value="">Sélectionnez un niveau</option>
            <option <?php if (get_value($values, ['level']) === 'Seconde') echo 'selected'; ?>>Seconde</option>
            <option <?php if (get_value($values, ['level']) === 'Première') echo 'selected'; ?>>Première</option>
            <option <?php if (get_value($values, ['level']) === 'Terminale') echo 'selected'; ?>>Terminale</option>
          </select>
          <?php if ($levelError): ?>
            <p class="mt-1 text-sm text-red-600"><?php echo e($errors['level']); ?></p>
          <?php endif; ?>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
          Tous les champs suivis de <span class="text-red-500">*</span> sont obligatoires.
        </div>

        <div class="flex items-center justify-between gap-4 mt-2">
          <a href="?action=liste-classes" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
            <span class="material-icons">arrow_back</span> Retour à la liste
          </a>

          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
            <span class="material-icons">add</span> Créer la classe
          </button>
        </div>
      </form>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-lg p-4">
      <div class="flex items-start gap-3">
        <div class="text-blue-500 mt-1"><span class="material-icons">info</span></div>
        <div>
          <h4 class="font-medium text-blue-800">💡 Conseil</h4>
          <p class="text-sm text-blue-700/90 mt-1">Une fois la classe créée, vous pourrez y associer des élèves et gérer leurs sanctions.</p>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Créer une classe';
require __DIR__ . '/layout.php';