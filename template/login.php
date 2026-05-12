<?php
$errors = $errors ?? [];
$values = $values ?? ['email' => ''];
$registered = $registered ?? null;

ob_start();
?>
<main class="flex-grow container mx-auto px-6 py-12 flex items-center justify-center">
  <div class="w-full max-w-lg">
    <div class="bg-primary text-white rounded-t-lg px-8 py-10 text-center">
      <h1 class="text-3xl font-bold flex items-center justify-center gap-3">
        <span class="material-icons text-4xl">lock_open</span>
        Connexion
      </h1>
      <p class="mt-2 text-blue-100">Accédez à votre espace personnel</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-b-lg shadow-lg p-8">
      <?php if (!empty($registered)): ?>
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.</div>
      <?php endif; ?>

      <?php if (!empty($errors['login'])): ?>
        <div class="mb-4 text-red-700 bg-red-100 p-3 rounded"><?php echo htmlspecialchars($errors['login']); ?></div>
      <?php endif; ?>

      <form class="space-y-6" method="post" action="?action=login">
        <div>
          <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="email">
            <span class="material-icons text-lg text-gray-400">email</span>
            Adresse email
          </label>
          <input id="email" name="email" type="email" autofocus placeholder="votre.email@exemple.com" value="<?php echo htmlspecialchars($values['email'] ?? ''); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"/>
        </div>

        <div>
          <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300" for="password">
            <span class="material-icons text-lg text-gray-400">lock</span>
            Mot de passe
          </label>
          <input id="password" name="password" type="password" placeholder="Votre mot de passe"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"/>
        </div>

        <div>
          <button class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700" type="submit">
            <span class="material-icons">login</span> Se connecter
          </button>
        </div>
      </form>

      <div class="mt-8 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">Pas encore de compte ? <a class="font-medium text-primary hover:text-blue-700" href="?action=register">Créer un compte</a></p>
        <a class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mt-3" href="?action=index"><span class="material-icons">arrow_back</span> Retour à l'accueil</a>
      </div>
    </div>
  </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Connexion';
require __DIR__ . '/layout.php';