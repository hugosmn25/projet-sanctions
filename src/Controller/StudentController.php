<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\StudentRepository;

/**
 * Controller pour la gestion des élèves (US7-1 / US7-2)
 */
class StudentController
{
    private View $view;
    private StudentRepository $students;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../template');
        $pdo = Database::getConnection();
        $this->students = new StudentRepository($pdo);
    }

    /**
     * Formulaire création élève (GET + POST)
     */
    public function create(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=create_student'));
        }

        $errors = [];
        $values = ['nom' => '', 'prenom' => '', 'date_naissance' => '', 'classe_id' => ''];

        // load classes for select
        $classes = $this->students->findClassesList();

        if ($request->isPost()) {
            $nom = trim((string)$request->post('nom', ''));
            $prenom = trim((string)$request->post('prenom', ''));
            $dob = trim((string)$request->post('date_naissance', ''));
            $classe_id = (int)$request->post('classe_id', 0);

            $values['nom'] = $nom;
            $values['prenom'] = $prenom;
            $values['date_naissance'] = $dob;
            $values['classe_id'] = $classe_id;

            // Validations
            if ($nom === '' || strlen($nom) < 2) {
                $errors['nom'] = 'Le nom est obligatoire (2+ caractères).';
            }
            if ($prenom === '' || strlen($prenom) < 2) {
                $errors['prenom'] = 'Le prénom est obligatoire (2+ caractères).';
            }

            // Date validation expected format JJ/MM/AAAA
            $dateOk = false;
            if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $dob, $m)) {
                $d = intval($m[1]); $mo = intval($m[2]); $y = intval($m[3]);
                if (checkdate($mo, $d, $y)) {
                    // ensure birth date is before today
                    $birth = \DateTime::createFromFormat('d/m/Y', $dob);
                    $now = new \DateTime('now');
                    if ($birth < $now) $dateOk = true;
                }
            }
            if (!$dateOk) $errors['date_naissance'] = 'Date invalide, format JJ/MM/AAAA et antérieure à aujourd\'hui.';

            if ($classe_id <= 0 || !$this->students->classExists($classe_id)) {
                $errors['classe_id'] = 'Veuillez sélectionner une classe valide.';
            }

            if (empty($errors)) {
                // convert date to YYYY-MM-DD for DB
                $dt = \DateTime::createFromFormat('d/m/Y', $dob);
                $dbDate = $dt->format('Y-m-d');

                $created = $this->students->create([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'date_naissance' => $dbDate,
                    'classe_id' => $classe_id
                ]);
                if ($created !== false) {
                    $response->redirect('?action=liste-eleves&created=1');
                } else {
                    $errors['general'] = 'Impossible de créer l\'élève, réessayez.';
                }
            }
        }

        $this->view->render('creation-eleve', [
            'errors' => $errors,
            'values' => $values,
            'classes' => $classes
        ]);
    }

    /**
     * Liste des élèves
     */
    public function list(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=liste-eleves'));
        }

        $students = $this->students->findAll();
        $created = $request->get('created', null);

        $this->view->render('liste-eleves', [
            'students' => $students,
            'created' => $created
        ]);
    }
}