<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\ClassRepository;

/**
 * Controller pour la gestion des classes (US5-1 / US5-2)
 */
class ClassController
{
    private View $view;
    private ClassRepository $classes;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../template');
        $pdo = Database::getConnection();
        $this->classes = new ClassRepository($pdo);
    }

    /**
     * Affiche le formulaire et traite la création (GET / POST)
     */
    public function create(Request $request, Response $response)
    {
        // utilisateur doit être connecté
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=create_class'));
        }

        $errors = [];
        $values = ['name' => '', 'level' => ''];

        if ($request->isPost()) {
            $name = trim((string)$request->post('class-name', ''));
            $level = trim((string)$request->post('level', ''));

            $values['name'] = $name;
            $values['level'] = $level;

            if ($name === '') {
                $errors['name'] = 'Le nom de la classe est obligatoire.';
            }
            if ($level === '' || $level === 'Sélectionnez un niveau') {
                $errors['level'] = 'Le niveau est obligatoire.';
            }

            // optional: check duplicate
            if (empty($errors) && $this->classes->existsByName($name)) {
                $errors['name'] = 'Une classe avec ce nom existe déjà.';
            }

            if (empty($errors)) {
                $inserted = $this->classes->create(['name' => $name, 'level' => $level]);
                if ($inserted !== false) {
                    // redirect to list with success flag
                    $response->redirect('?action=liste-classes&created=1');
                } else {
                    $errors['general'] = "Impossible de créer la classe, réessayez.";
                }
            }
        }

        // Render form (we pass errors/values in case you want to show them) — template unifié simple
        $this->view->render('creation-classe', [
            'errors' => $errors,
            'values' => $values
        ]);
    }

    /**
     * Liste des classes
     */
    public function list(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=liste-classes'));
        }

        $classes = $this->classes->findAll();
        $created = $request->get('created', null);

        $this->view->render('liste-classes', [
            'classes' => $classes,
            'created' => $created
        ]);
    }
}