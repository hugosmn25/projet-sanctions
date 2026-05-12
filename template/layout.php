<?php
/**
 * template/layout.php
 * Attendu:
 *  - $title (string) : titre de la page
 *  - $content (string) : HTML de la zone <main>
 *
 * Doit être inclus depuis un template qui a préalablement fait:
 *   ob_start(); ... echo le contenu principal ...; $content = ob_get_clean(); $title = '...'; require __DIR__.'/layout.php';
 */
$title = $title ?? 'Application';
?>
<!DOCTYPE html>
<html lang="fr"><head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title><?php echo htmlspecialchars($title); ?> - Gestion des Sanctions</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          primary: "#2176f3",
          "primary-dark": "#1d5fd6",
          "background-light": "#f3f4f6",
          "background-dark": "#111827"
        },
        fontFamily: { display: ['Poppins','sans-serif'] },
        borderRadius: { xl: '1rem' }
      }
    }
  }
</script>
</head>
<body class="bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-100 font-display">
<div class="min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white dark:bg-slate-800 shadow-sm">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a class="text-primary dark:text-blue-300 font-semibold text-lg" href="?action=index">
        <span class="text-2xl">📋</span>
        <span>Gestion des Sanctions</span>
      </a>
      <span class="text-sm text-gray-500 dark:text-gray-400">Application Vie Scolaire</span>
    </div>
  </header>

  <!-- Nav -->
  <nav class="bg-primary">
    <div class="container mx-auto px-6 py-2">
      <div class="flex items-center gap-6 text-white text-sm">
        <a class="inline-flex items-center gap-2" href="?action=dashboard"><span class="material-icons">dashboard</span> Tableau de Bord</a>
        <a class="inline-flex items-center gap-2" href="?action=liste-eleves"><span class="material-icons">groups</span> Élèves</a>
        <a class="inline-flex items-center gap-2" href="?action=liste-classes"><span class="material-icons">class</span> Classes</a>
        <a class="inline-flex items-center gap-2" href="?action=liste-sanctions"><span class="material-icons">gavel</span> Sanctions</a>
        <a class="inline-flex items-center gap-2" href="?action=liste-professeurs"><span class="material-icons">person</span> Professeurs</a>
      </div>
    </div>
  </nav>

  <!-- Main (injected) -->
  <?php echo $content; ?>

  <!-- Footer -->
  <footer class="bg-slate-800 text-slate-300 mt-auto">
    <div class="container mx-auto px-6 py-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h4 class="font-bold text-white mb-3">Gestion des Sanctions</h4>
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

      <div class="mt-12 border-t border-slate-700 pt-6 text-center text-sm text-slate-500">
        © 2025 Application de Gestion des Sanctions. Tous droits réservés.
      </div>
    </div>
</footer>
</div>
</body></html>