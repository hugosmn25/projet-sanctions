<?php
$errors = $errors ?? [];
$values = $values ?? [
    'date' => '',
    'motif' => '',
    'type' => '',
    'professor_id' => '',
    'student_id' => ''
];
$professors = $professors ?? [];
$students = $students ?? [];
$types = $types ?? [];

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function has_error($errors, $key){ return !empty($errors[$key]); }

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="max-w-3xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 mb-6 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-4">
        <span class="material-icons text-5xl">gavel</span>
        Créer une sanction
      </h1>
      <p class="mt-2 text-blue-100/90">Enregistrez un incident disciplinaire</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Détails de la sanction</h2>
        <p class="mt-1 text-sm text-gray-500">Remplissez les champs obligatoires pour enregistrer la sanction</p>
      </div>

      <form method="post" action="?action=create_sanction" class="p-6 space-y-6" novalidate>
        <?php if (!empty($errors['general'])): ?>
          <div class="text-red-700 bg-red-100 p-3 rounded"><?php echo e($errors['general']); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Date de l'incident (JJ/MM/AAAA) <span class="text-red-500">*</span></label>
            <input
              name="date"
              type="text"
              placeholder="Ex: 15/09/2025"
              value="<?php echo e($values['date'] ?? ''); ?>"
              class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'date') ? 'border-red-500' : 'border-gray-200'; ?>"/>
            <?php if (has_error($errors,'date')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['date']); ?></p>
            <?php endif; ?>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Type de sanction <span class="text-red-500">*</span></label>
            <select name="type" class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'type') ? 'border-red-500' : 'border-gray-200'; ?>">
              <option value="">-- Sélectionnez un type --</option>
              <?php foreach ($types as $key => $label): ?>
                <option value="<?php echo e($key); ?>" <?php echo ($values['type'] === $key) ? 'selected' : ''; ?>><?php echo e($label); ?></option>
              <?php endforeach; ?>
            </select>
            <?php if (has_error($errors,'type')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['type']); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Motif <span class="text-red-500">*</span></label>
          <textarea name="motif" rows="4" placeholder="Décrivez l'incident (min. 10 caractères)" class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'motif') ? 'border-red-500' : 'border-gray-200'; ?>"><?php echo e($values['motif'] ?? ''); ?></textarea>
          <?php if (has_error($errors,'motif')): ?>
            <p class="mt-1 text-sm text-red-600"><?php echo e($errors['motif']); ?></p>
          <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Professeur <span class="text-red-500">*</span></label>
            <select name="professor_id" class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'professor_id') ? 'border-red-500' : 'border-gray-200'; ?>">
              <option value="">-- Sélectionnez un professeur --</option>
              <?php foreach ($professors as $p): ?>
                <option value="<?php echo e($p['id']); ?>" <?php echo ((string)$values['professor_id'] === (string)$p['id']) ? 'selected' : ''; ?>>
                  <?php echo e($p['nom'] . ' ' . $p['prenom'] . ($p['matiere'] ? ' — ' . $p['matiere'] : '')); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (has_error($errors,'professor_id')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['professor_id']); ?></p>
            <?php endif; ?>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Élève <span class="text-red-500">*</span></label>
            <select name="student_id" class="mt-2 block w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary <?php echo has_error($errors,'student_id') ? 'border-red-500' : 'border-gray-200'; ?>">
              <option value="">-- Sélectionnez un élève --</option>
              <?php foreach ($students as $s): ?>
                <option value="<?php echo e($s['id']); ?>" <?php echo ((string)$values['student_id'] === (string)$s['id']) ? 'selected' : ''; ?>>
                  <?php echo e($s['nom'] . ' ' . $s['prenom'] . (isset($s['class_name']) && $s['class_name'] ? ' — ' . $s['class_name'] : '')); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (has_error($errors,'student_id')): ?>
              <p class="mt-1 text-sm text-red-600"><?php echo e($errors['student_id']); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
          Tous les champs suivis de <span class="text-red-500">*</span> sont obligatoires.
        </div>

        <div class="flex items-center justify-between gap-4 mt-2">
          <a href="?action=liste-sanctions" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium shadow">
            <span class="material-icons">arrow_back</span> Retour à la liste
          </a>

          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-medium shadow">
            <span class="material-icons">save</span> Créer la sanction
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Créer une sanction';
require __DIR__ . '/layout.php';