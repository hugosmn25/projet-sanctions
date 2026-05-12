<?php 
$lieux = $lieux ?? [];
ob_start(); 
?>
<main class="flex-grow container mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-6">Gestion des Lieux</h1>
    
    <div class="bg-white rounded-xl shadow-lg p-6">
        <ul>
            <?php foreach($lieux as $lieu): ?>
                <li class="border-b py-2">
                    <?php echo htmlspecialchars($lieu['nom']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>
<?php 
$content = ob_get_clean(); 
$title = 'Liste des lieux'; 
require __DIR__ . '/layout.php'; // On injecte le tout dans le design principal