-- Combined initialization for db_sanctions
-- Date: 2025-12-28
-- Ajustez le nom d'utilisateur / mot de passe ou exécutez depuis votre client habituel.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

CREATE DATABASE IF NOT EXISTS `db_sanctions`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;
USE `db_sanctions`;

-- --------------------------------------------------------
-- Table: utilisateur (compte admin / personnel)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `prenom` VARCHAR(100) DEFAULT NULL,
  `nom` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `utilisateur` (`id`, `email`, `password`, `prenom`, `nom`, `created_at`)
SELECT 1, 'raytray.production@gmail.com',
       '$2y$10$JMUBx8w46EkLqxIYNtNxQORivn8QvDvnOyeEuCsiDedt1F1sof5RG',
       'Hugo', 'SIMONIN', '2025-11-24 19:39:16'
WHERE NOT EXISTS (SELECT 1 FROM `utilisateur` WHERE id = 1);

-- --------------------------------------------------------
-- Table: classes
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `classes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `level` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_classes_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: students
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `date_naissance` DATE NOT NULL,
  `classe_id` INT UNSIGNED NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_students_classe` (`classe_id`),
  CONSTRAINT `fk_students_classe` FOREIGN KEY (`classe_id`) REFERENCES `classes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: professors
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `professors` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `matiere` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_prof_nom_prenom` (`nom`, `prenom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: sanctions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sanctions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` DATE NOT NULL,
  `motif` TEXT NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `professor_id` INT UNSIGNED NOT NULL,
  `student_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_sanctions_prof` (`professor_id`),
  INDEX `idx_sanctions_student` (`student_id`),
  CONSTRAINT `fk_sanctions_professor` FOREIGN KEY (`professor_id`) REFERENCES `professors`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sanctions_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Jeu d'essai 
-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `sanctions`;
TRUNCATE TABLE `students`;
TRUNCATE TABLE `professors`;
TRUNCATE TABLE `classes`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Table: classes (Respecte colonnes 'name' et 'level')
INSERT INTO `classes` (`id`, `name`, `level`) VALUES
(1, 'Seconde V', 'Seconde'),
(2, 'Première G1', 'Première Générale'),
(3, 'Terminale G2', 'Terminale Générale');

-- 2. Table: students (Utilise 'classe_id')
INSERT INTO `students` (`id`, `nom`, `prenom`, `date_naissance`, `classe_id`) VALUES
(1, 'Gallardo', 'Mickael', '2012-03-15', 1), -- 1 sanction
(2, 'Martin', 'Bob', '2009-07-22', 2),        -- 2 sanctions
(3, 'Dubois', 'Alice', '2008-11-30', 3),     -- 0 sanction (Test cas vide)
(4, 'Morel', 'Kevin', '2012-05-10', 1);      -- 0 sanction (Test cas vide)

-- 3. Table: professors
INSERT INTO `professors` (`id`, `nom`, `prenom`, `matiere`) VALUES
(1, 'Bana Owona', 'Jeremy', 'Mathématiques'),
(2, 'Leroy', 'David', 'Histoire'),
(3, 'Curie', 'Marie', 'Physique-Chimie');

INSERT INTO `sanctions` (`id`, `date`, `motif`, `type`, `professor_id`, `student_id`) VALUES
(1, '2026-01-10', 'Retard répété de plus de 15 minutes', 'Avertissement', 1, 1),
(2, '2026-01-15', 'Usage du téléphone portable en cours', 'Heure de colle', 2, 2),
(3, '2026-02-05', 'Insolence caractérisée', 'Exclusion temporaire', 1, 2);