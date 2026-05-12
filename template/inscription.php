<?php
$errors = $errors ?? [];
$values = $values ?? ['email' => '', 'prenom' => '', 'nom' => ''];
$success = $success ?? null;
ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12">
  <div class="w-full max-w-3xl mx-auto">
    <div class="bg-gradient-to-r from-blue-600 to-primary-dark text-white rounded-t-lg px-8 py-10 text-center shadow-lg mb-6">
      <h1 class="text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-3">
        <span class="material-icons text-5xl">edit_note</span> Créer un compte
      </h1>
      <p class="mt-2 text-blue-100/90">Inscrivez-vous pour accéder au système de gestion</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-b-lg shadow-lg p-8">
      <?php if ($success): ?>
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>
      <?php if (!empty($errors['general'])): ?>
        <div class="mb-4 text-red-700 bg-red-100 p-3 rounded"><?php echo htmlspecialchars($errors['general']); ?></div>
      <?php endif; ?>

      <form class="space-y-6" method="post" action="?action=register">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="nom">
              <span class="material-icons text-lg">person_outline</span>
              Nom <span class="text-red-500 ml-1">*</span>
            </label>
            <input id="nom" name="nom" type="text" placeholder="Votre nom" value="<?php echo htmlspecialchars($values['nom'] ?? '') ?>"
              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
            <?php if (!empty($errors['nom'])): ?><p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($errors['nom']); ?></p><?php endif; ?>
          </div>

          <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="prenom">
              <span class="material-icons text-lg">person_outline</span>
              Prénom <span class="text-red-500 ml-1">*</span>
            </label>
            <input id="prenom" name="prenom" type="text" placeholder="Votre prénom" value="<?php echo htmlspecialchars($values['prenom'] ?? '') ?>"
              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
            <?php if (!empty($errors['prenom'])): ?><p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($errors['prenom']); ?></p><?php endif; ?>
          </div>
        </div>

        <div>
          <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="email">
            <span class="material-icons text-lg">alternate_email</span>
            Adresse email <span class="text-red-500 ml-1">*</span>
          </label>
          <input id="email" name="email" type="email" placeholder="votre.email@exemple.com" value="<?php echo htmlspecialchars($values['email'] ?? '') ?>"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
          <?php if (!empty($errors['email'])): ?><p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($errors['email']); ?></p><?php endif; ?>
        </div>

        <div>
          <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="password">
            <span class="material-icons text-lg">lock_outline</span>
            Mot de passe <span class="text-red-500 ml-1">*</span>
          </label>
          <input id="password" name="password" type="password" placeholder="Au moins 6 caractères"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
          <?php if (!empty($errors['password'])): ?><p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($errors['password']); ?></p><?php endif; ?>
        </div>

        <div>
          <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="password_confirmation">
            <span class="material-icons text-lg">lock_outline</span>
            Confirmer le mot de passe <span class="text-red-500 ml-1">*</span>
          </label>
          <input id="password_confirmation" name="confirm_password" type="password" placeholder="Répétez votre mot de passe"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
          <?php if (!empty($errors['confirm_password'])): ?><p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($errors['confirm_password']); ?></p><?php endif; ?>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
          Tous les champs suivis de <span class="text-red-500">*</span> sont obligatoires.
        </div>

        <div>
          <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700">
            <span class="material-icons">add_circle_outline</span> Créer mon compte
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Inscription';
require __DIR__ . '/layout.php';