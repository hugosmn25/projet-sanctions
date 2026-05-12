<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\SanctionRepository;
use App\Repository\ProfessorRepository;
use App\Repository\StudentRepository;

/**
 * Controller pour la gestion des sanctions (US13 / US16)
 */
class SanctionController
{
    private View $view;
    private SanctionRepository $sanctions;
    private ProfessorRepository $professors;
    private StudentRepository $students;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../template');
        $pdo = Database::getConnection();
        $this->sanctions = new SanctionRepository($pdo);
        $this->professors = new ProfessorRepository($pdo);
        $this->students = new StudentRepository($pdo);
    }

    /**
     * Formulaire création sanction (GET + POST)
     */
    public function create(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=create_sanction'));
        }

        $errors = [];
        $values = [
            'date' => '',
            'motif' => '',
            'type' => '',
            'professor_id' => '',
            'student_id' => ''
        ];

        // Chargement des listes pour les selects
        $professors = $this->professors->findList(); // id, nom, prenom, matiere
        $students = $this->students->findAll(); // id, nom, prenom, class_name...

        if ($request->isPost()) {
            $dateInput = trim((string)$request->post('date', ''));
            $motif = trim((string)$request->post('motif', ''));
            $type = trim((string)$request->post('type', ''));
            $professorId = (int)$request->post('professor_id', 0);
            $studentId = (int)$request->post('student_id', 0);

            $values['date'] = $dateInput;
            $values['motif'] = $motif;
            $values['type'] = $type;
            $values['professor_id'] = $professorId;
            $values['student_id'] = $studentId;

            // Validation date JJ/MM/AAAA et non future
            $dateOk = false;
            if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $dateInput, $m)) {
                $d = (int)$m[1]; $mo = (int)$m[2]; $y = (int)$m[3];
                if (checkdate($mo, $d, $y)) {
                    $dt = \DateTime::createFromFormat('d/m/Y', $dateInput);
                    $now = new \DateTime('now');
                    if ($dt <= $now) {
                        $dateOk = true;
                    } else {
                        $errors['date'] = 'La date ne peut pas être dans le futur.';
                    }
                }
            }
            if (!$dateOk && !isset($errors['date'])) {
                $errors['date'] = 'Date invalide, format attendu JJ/MM/AAAA.';
            }

            // Motif
            if ($motif === '' || mb_strlen($motif) < 10) {
                $errors['motif'] = 'Le motif est obligatoire (minimum 10 caractères).';
            }

            // Type
            $allowedTypes = SanctionRepository::getTypes();
            if ($type === '' || !array_key_exists($type, $allowedTypes)) {
                $errors['type'] = 'Veuillez sélectionner un type de sanction valide.';
            }

            // Professeur existence
            if ($professorId <= 0 || !$this->professors->exists($professorId)) {
                $errors['professor_id'] = 'Veuillez sélectionner un professeur valide.';
            }

            // Élève existence (vérification dans la liste récupérée)
            $studentExists = false;
            foreach ($students as $s) {
                if ((int)($s['id'] ?? 0) === $studentId) {
                    $studentExists = true;
                    break;
                }
            }
            if ($studentId <= 0 || !$studentExists) {
                $errors['student_id'] = 'Veuillez sélectionner un élève valide.';
            }

            if (empty($errors)) {
                // Conversion date en YYYY-MM-DD
                $dt = \DateTime::createFromFormat('d/m/Y', $dateInput);
                $dbDate = $dt->format('Y-m-d');

                $created = $this->sanctions->create([
                    'date' => $dbDate,
                    'motif' => $motif,
                    'type' => $type,
                    'professor_id' => $professorId,
                    'student_id' => $studentId
                ]);

                if ($created !== false) {
                    $response->redirect('?action=liste-sanctions&created=1');
                    return;
                } else {
                    $errors['general'] = 'Impossible de créer la sanction, réessayez.';
                }
            }
        }

        $this->view->render('creation-sanction', [
            'errors' => $errors,
            'values' => $values,
            'professors' => $professors,
            'students' => $students,
            'types' => SanctionRepository::getTypes()
        ]);
    }

    /**
     * Liste des sanctions (US16)
     */
    public function list(Request $request, Response $response)
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=liste-sanctions'));
        }

        $sanctions = $this->sanctions->findAll();
        // convertir la clé type en libellé lisible pour l'affichage
        $types = SanctionRepository::getTypes();
        foreach ($sanctions as &$s) {
            $s['type_label'] = $types[$s['type']] ?? $s['type'];
        }
        unset($s);

        $created = $request->get('created', null);

        $this->view->render('liste-sanctions', [
            'sanctions' => $sanctions,
            'created' => $created
        ]);
    }
}