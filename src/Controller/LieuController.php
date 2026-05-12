<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\LieuRepository;

class LieuController {
    private View $view;
    private LieuRepository $lieux;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../template');
        $this->lieux = new LieuRepository(Database::getConnection());
    }

    // La méthode pour afficher la liste
    public function list(Request $request, Response $response) {
        // 1. On vérifie que l'utilisateur est connecté (comme dans tous tes contrôleurs)
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login');
        }

        // 2. On demande les données au Repository
        $listeLieux = $this->lieux->findAll();

        // 3. On envoie les données au fichier template HTML
        $this->view->render('liste-lieux', [
            'lieux' => $listeLieux
        ]);
    }
    
    // (Tu ferais la même chose avec une méthode create() pour gérer l'ajout)
}