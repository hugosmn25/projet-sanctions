<?php
namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Config\Database;
use App\Repository\UserRepository;
use App\Repository\ClassRepository;
use App\Repository\StudentRepository;
use App\Repository\ProfessorRepository;
use App\Repository\SanctionRepository;
use PDO;
use PDOException;

class AuthController
{
    private View $view;
    private $pdo = null;
    private $users = null;
    private $classes = null;
    private $students = null;
    private $professors = null;
    private $sanctions = null;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../template');
    }

    private function getPdo(): PDO
    {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }
        $this->pdo = Database::getConnection();
        return $this->pdo;
    }

    private function getUserRepo(): UserRepository
    {
        if ($this->users instanceof UserRepository) return $this->users;
        $this->users = new UserRepository($this->getPdo());
        return $this->users;
    }

    private function getClassRepo(): ClassRepository
    {
        if ($this->classes instanceof ClassRepository) return $this->classes;
        $this->classes = new ClassRepository($this->getPdo());
        return $this->classes;
    }

    private function getStudentRepo(): StudentRepository
    {
        if ($this->students instanceof StudentRepository) return $this->students;
        $this->students = new StudentRepository($this->getPdo());
        return $this->students;
    }

    private function getProfessorRepo(): ProfessorRepository
    {
        if ($this->professors instanceof ProfessorRepository) return $this->professors;
        $this->professors = new ProfessorRepository($this->getPdo());
        return $this->professors;
    }

    private function getSanctionRepo(): SanctionRepository
    {
        if ($this->sanctions instanceof SanctionRepository) return $this->sanctions;
        $this->sanctions = new SanctionRepository($this->getPdo());
        return $this->sanctions;
    }

    public function home(Request $request, Response $response)
    {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $response->redirect('?action=dashboard');
        }
        $this->view->render('accueil', ['user' => null]);
    }

    public function login(Request $request, Response $response)
    {
        if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $response->redirect('?action=dashboard');
        }

        $errors = [];
        $values = ['email' => ''];

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $values['email'] = $email;

            if ($email === '') {
                $errors['email'] = 'Adresse email requise.';
            }
            if ($password === '') {
                $errors['password'] = 'Mot de passe requis.';
            }

            if (empty($errors)) {
                $user = null;
                try {
                    $user = $this->getUserRepo()->findByEmail($email);
                } catch (\Throwable $e) {
                    $user = null;
                }

                if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user['id'] ?? null;
                    $_SESSION['prenom'] = $user['prenom'] ?? '';
                    $_SESSION['nom'] = $user['nom'] ?? '';
                    $_SESSION['email'] = $user['email'] ?? '';

                    if (function_exists('session_write_close')) {
                        session_write_close();
                    }

                    $response->redirect('?action=dashboard');
                    return;
                } else {
                    $errors['login'] = 'Email ou mot de passe invalide.';
                }
            }
        }

        $this->view->render('login', [
            'errors' => $errors,
            'values' => $values,
            'registered' => $_GET['registered'] ?? null
        ]);
    }

    public function register(Request $request, Response $response)
    {
        return $this->handleRegister($request, $response);
    }

    /**
     * Logique d'inscription partagée
     */
    private function handleRegister(Request $request, Response $response)
    {
        if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $response->redirect('?action=dashboard');
        }

        $errors = [];
        $values = ['prenom' => '', 'nom' => '', 'email' => ''];

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['confirm_password'] ?? '';

            $values['prenom'] = $prenom;
            $values['nom'] = $nom;
            $values['email'] = $email;

            // Validation basique
            if ($prenom === '') $errors['prenom'] = 'Prénom requis.';
            if ($nom === '') $errors['nom'] = 'Nom requis.';
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email invalide.';
            if ($password === '') $errors['password'] = 'Mot de passe requis.';
            elseif (strlen($password) < 6) $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
            if ($password !== $passwordConfirm) $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';

            if (empty($errors)) {
                // Quick existence check
                try {
                    $exists = (bool)$this->getUserRepo()->findByEmail($email);
                } catch (\Throwable $e) {
                    $exists = false;
                }

                if ($exists) {
                    $errors['email'] = 'Un compte existe déjà avec cet email.';
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $payload = [
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'email' => $email,
                        'password' => $hashed
                    ];

                    try {
                        $createdId = $this->getUserRepo()->create($payload);
                        // create() doit renvoyer l'id inséré
                        if ($createdId) {
                            $response->redirect('?action=login&registered=1');
                            return;
                        } else {
                            $errors['db'] = 'Impossible de créer le compte pour le moment.';
                        }
                    } catch (PDOException $e) {
                        $ei = $e->errorInfo ?? null;
                        $sqlState = $ei[0] ?? null;
                        $sqlCode = $ei[1] ?? null;
                        // Duplicate entry MySQL
                        if ($sqlState === '23000' || (int)$sqlCode === 1062) {
                            $errors['email'] = 'Un compte existe déjà avec cet email.';
                        } else {
                            error_log('[AuthController][register] PDOException: ' . $e->getMessage());
                            $errors['db'] = 'Erreur serveur, réessaye plus tard.';
                        }
                    } catch (\Throwable $e) {
                        error_log('[AuthController][register] Exception: ' . $e->getMessage());
                        $errors['db'] = 'Erreur serveur, réessaye plus tard.';
                    }
                }
            }
        }

        $this->view->render('inscription', [
            'errors' => $errors,
            'values' => $values
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'] ?? '/', $params['domain'] ?? '', $params['secure'] ?? false, $params['httponly'] ?? true);
        }
        @session_destroy();

        $response->redirect('?action=login');
    }

    public function dashboard(Request $request, Response $response)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $response->redirect('?action=login&redirect=' . urlencode('?action=dashboard'));
        }

        $user = [
            'prenom' => $_SESSION['prenom'] ?? '',
            'nom'    => $_SESSION['nom'] ?? '',
            'email'  => $_SESSION['email'] ?? '',
        ];

        // Default counts
        $totalStudents = 0;
        $totalClasses = 0;
        $totalUsers = 0;
        $totalProfessors = 0;
        $totalSanctions = 0;

        try {
            $totalStudents = $this->getStudentRepo()->countAll();
        } catch (\Throwable $e) {
            $totalStudents = 0;
        }

        try {
            $totalClasses = $this->getClassRepo()->countAll();
        } catch (\Throwable $e) {
            $totalClasses = 0;
        }

        try {
            $totalUsers = method_exists($this->getUserRepo(), 'countAll') ? $this->getUserRepo()->countAll() : 0;
        } catch (\Throwable $e) {
            $totalUsers = 0;
        }

        try {
            $totalProfessors = $this->getProfessorRepo()->countAll();
        } catch (\Throwable $e) {
            $totalProfessors = 0;
        }

        try {
            $totalSanctions = $this->getSanctionRepo()->countAll();
        } catch (\Throwable $e) {
            $totalSanctions = 0;
        }

        $stats = [
            'total_sanctions' => $totalSanctions,
            'total_students' => $totalStudents,
            'total_professeurs' => $totalProfessors,
            'total_classes' => $totalClasses,
            'total_users' => $totalUsers,
        ];

        $this->view->render('dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }

    private function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) return null;
        try {
            return $this->getUserRepo()->findById((int)$_SESSION['user_id']);
        } catch (\Throwable $e) {
            return null;
        }
    }
}