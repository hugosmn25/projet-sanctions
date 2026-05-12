<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\ProfessorRepository;

/**
 * Controller pour la gestion des professeurs (US10)
 */
class ProfessorController
{
    private View $view;
    private ProfessorRepository $professors;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../template');
        $pdo = Database::getConnection();
        $this->professors = new ProfessorRepository($pdo);
    }

    /**
     * Formulaire création professeur (GET + POST)
     */
    public function create(Request $request, Response $response)
    {
        // Redirects reference the French action name used in templates (create_professeur).
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=create_professeur'));
        }

        $errors = [];
        $values = ['nom' => '', 'prenom' => '', 'matiere' => ''];

        if ($request->isPost()) {
            $nom = trim((string)$request->post('nom', ''));
            $prenom = trim((string)$request->post('prenom', ''));
            $matiere = trim((string)$request->post('matiere', ''));

            $values['nom'] = $nom;
            $values['prenom'] = $prenom;
            $values['matiere'] = $matiere;

            // Validations conformes à l'US10
            if ($nom === '' || mb_strlen($nom) < 2 || mb_strlen($nom) > 50) {
                $errors['nom'] = 'Le nom est obligatoire (2 à 50 caractères).';
            }
            if ($prenom === '' || mb_strlen($prenom) < 2 || mb_strlen($prenom) > 50) {
                $errors['prenom'] = 'Le prénom est obligatoire (2 à 50 caractères).';
            }
            if ($matiere === '' || mb_strlen($matiere) < 2 || mb_strlen($matiere) > 100) {
                $errors['matiere'] = 'La matière est obligatoire (2 à 100 caractères).';
            }

            if (empty($errors)) {
                $created = $this->professors->create([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'matiere' => $matiere
                ]);
                if ($created !== false) {
                    $response->redirect('?action=liste-professeurs&created=1');
                    return;
                } else {
                    $errors['general'] = 'Impossible de créer le professeur, réessayez.';
                }
            }
        }

        $this->view->render('creation-professeur', [
            'errors' => $errors,
            'values' => $values
        ]);
    }

    /**
     * Liste des professeurs
     */
    public function list(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=liste-professeurs'));
        }

        $professors = $this->professors->findAll();
        $created = $request->get('created', null);

        $this->view->render('liste-professeurs', [
            'professors' => $professors,
            'created' => $created
        ]);
    }
}