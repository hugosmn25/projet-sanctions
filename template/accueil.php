<?php

$logged = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$prenom = $user['prenom'] ?? ($logged ? ($_SESSION['prenom'] ?? '') : '');
?>

<!DOCTYPE html>
<html lang="fr"><head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Gestion des Sanctions</title>

<!-- Fonts & Tailwind -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          primary: "#2176f3",
          "primary-dark": "#1d5fd6",
          "bg-light": "#f8fafc",
          "card": "#ffffff",
        },
        fontFamily: {
          display: ["Poppins", "sans-serif"],
        },
        borderRadius: {
          xl: "1rem",
          lg: "0.75rem"
        }
      }
    }
  }
</script>

</head>
<body class="bg-bg-light dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-display">
<div class="min-h-screen flex flex-col">

<header class="bg-white dark:bg-slate-800 shadow-sm">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center gap-3">
        <span class="text-2xl">📋</span>
          <a href="?action=index" class="text-primary dark:text-blue-300 font-semibold text-lg">Gestion des Sanctions</a>
      </div>
        <div class="hidden md:block text-sm text-gray-500 dark:text-gray-400">Application Vie Scolaire</div>
    </div>
  </div>
</header>

  <!-- Blue nav bar -->
  <nav class="bg-primary">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="h-12 flex items-center">
        <a class="text-white text-sm inline-flex items-center gap-2 px-3 py-1" href="?action=index">
          <span class="material-icons-outlined">home</span>
          Accueil
        </a>
      </div>
    </div>
  </nav>

  <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Hero -->
    <section class="bg-gradient-to-br from-blue-600 to-primary-dark text-white rounded-xl shadow-xl p-8 md:p-12 mb-12">
      <div class="max-w-6xl mx-auto text-center">
        <div class="flex items-center justify-center gap-4">
          <span class="material-icons-outlined text-5xl">school</span>
          <h1 class="text-3xl md:text-5xl font-extrabold">Application de Gestion des Sanctions</h1>
        </div>
        <p class="mt-4 text-lg text-blue-100/90">Système de gestion de la vie scolaire pour le lycée</p>
      </div>
    </section>

    <!-- Action cards -->
    <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
      <div class="bg-card rounded-xl shadow-lg p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
          <span class="material-icons-outlined text-2xl text-blue-600">lock_open</span>
        </div>
        <h3 class="text-xl font-semibold mb-2">Connexion</h3>
        <p class="text-sm text-gray-500 mb-6">Accédez à votre espace personnel pour gérer les sanctions</p>
        <?php if ($logged): ?>
          <a href="?action=dashboard" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg shadow">
            <span class="material-icons-outlined">rocket_launch</span> Accéder au tableau de bord
          </a>
        <?php else: ?>
          <a href="?action=login" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg shadow">
            <span class="material-icons-outlined">rocket_launch</span> Se connecter
          </a>
        <?php endif; ?>
      </div>

      <div class="bg-card rounded-xl shadow-lg p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mb-4">
          <span class="material-icons-outlined text-2xl text-green-600">assignment_ind</span>
        </div>
        <h3 class="text-xl font-semibold mb-2">Créer un compte</h3>
        <p class="text-sm text-gray-500 mb-6">Inscrivez-vous pour accéder au système de gestion</p>
                  <a href="?action=register" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg shadow">
            <span class="material-icons-outlined">sparkles</span> S'inscrire
          </a>
      </div>
    </section>

    <!-- About / features -->
    <section class="max-w-6xl mx-auto bg-gradient-to-r from-white to-blue-50 rounded-xl p-8 shadow-inner">
      <h2 class="text-center text-2xl font-bold mb-8">🚀 À propos de l'application</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="px-6">
          <div class="mx-auto w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
            <span class="material-icons-outlined text-2xl text-blue-600">gavel</span>
          </div>
          <h4 class="font-semibold mb-2">Gestion des Sanctions</h4>
          <p class="text-sm text-gray-500">Enregistrez et suivez les sanctions des élèves de manière efficace</p>
        </div>

        <div class="px-6">
          <div class="mx-auto w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
            <span class="material-icons-outlined text-2xl text-blue-600">groups</span>
          </div>
          <h4 class="font-semibold mb-2">Gestion des Élèves</h4>
          <p class="text-sm text-gray-500">Centralisez les informations des élèves et leurs classes</p>
        </div>

        <div class="px-6">
          <div class="mx-auto w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
            <span class="material-icons-outlined text-2xl text-blue-600">bar_chart</span>
          </div>
          <h4 class="font-semibold mb-2">Tableau de Bord</h4>
          <p class="text-sm text-gray-500">Visualisez les statistiques et l'activité récente</p>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-slate-800 text-slate-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="material-icons-outlined text-primary text-2xl">assignment</span>
            <h4 class="font-bold text-white">Gestion des Sanctions</h4>
          </div>
          <p class="text-sm text-slate-400">Application de gestion de la vie scolaire pour le suivi des sanctions et incidents.</p>
        </div>

        <div>
          <h4 class="font-bold text-white mb-3">Liens utiles</h4>
          <ul class="space-y-2 text-sm text-slate-400">
            <li>Documentation</li>
            <li>Support</li>
            <li>Contact</li>
          </ul>
        </div>

        <div>
          <h4 class="font-bold text-white mb-3">Informations</h4>
          <p class="text-sm text-slate-400">Développé dans le cadre du BTS SIO - Projet CCF 2025</p>
        </div>
      </div>

      <div class="border-t border-slate-700 mt-8 pt-6 text-center text-sm text-slate-500">
        © 2025 Application de Gestion des Sanctions. Tous droits réservés.
      </div>
    </div>
  </footer>
</div>
</body></html>


