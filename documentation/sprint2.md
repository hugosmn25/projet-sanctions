# 🚀 Détail du Sprint 2 – Projet "Gestion des sanctions"

## 🎯 Objectif du Sprint 2
Étendre les fonctionnalités du Sprint 1 pour permettre la **gestion des professeurs et des sanctions** :  
création de professeurs, création et consultation des sanctions.  
L’objectif est de mettre en place les fonctionnalités essentielles permettant d’enregistrer et de suivre les sanctions dans l’établissement.

---

## 🔑 Légende des priorités

| Symbole | Priorité | Signification |
|----------|-----------|----------------|
| **★** | Haute priorité | Fonctionnalité essentielle au bon fonctionnement de l’application. Doit être développée dès que possible. |
| **■** | Priorité moyenne | Fonctionnalité importante mais non bloquante. Peut être réalisée après les fonctionnalités essentielles. |
| **○** *(facultatif)* | Basse priorité | Amélioration ou fonctionnalité complémentaire pouvant être différée à un sprint ultérieur. |

---

## 🔧 User Stories incluses

| ID | User Story | Priorité | Critères d'acceptation |
|----|-------------|-----------|------------------------|
| **US10** | En tant que personnel de vie scolaire connecté, je veux créer un professeur avec ses informations (nom, prénom, matière), afin de pouvoir l'associer à une sanction. | ★ | Formulaire d'ajout complet (nom, prénom, matière). Le professeur est ajouté à la base de données. Validation des champs obligatoires. |
| **US13** | En tant que personnel de vie scolaire connecté, je veux créer une sanction en précisant la date, le motif, le type, le professeur et l'élève concerné, afin d'enregistrer un incident. | ★ | Formulaire de création avec tous les champs requis (date, motif, type, professeur, élève). La sanction est enregistrée avec succès. Validation des relations (professeur et élève existants). |
| **US16** | En tant que personnel de vie scolaire connecté, je veux consulter la liste des sanctions, afin d'en assurer le suivi. | ★ | Liste complète de toutes les sanctions avec leurs informations (date, motif, type, professeur, élève). Interface claire et lisible. Affichage cohérent avec le design de l'application. |
| **US21** | En tant qu'utilisateur, je veux une interface claire et intuitive, afin d'effectuer les opérations courantes sans difficulté. | ★ | Navigation fluide entre les différentes fonctionnalités. Cohérence visuelle et ergonomique. Design responsive avec Tailwind CSS. |

---

## 🧩 Livrables attendus

- **Page de création de professeur** (accessible uniquement si connecté)
  - Formulaire avec champs : nom, prénom, matière
  - Validation des données
  - Message de confirmation après création
  
- **Page de création de sanction** (accessible uniquement si connecté)
  - Formulaire avec champs : date, motif, type, professeur (sélection), élève (sélection)
  - Liste déroulante pour sélectionner un professeur existant
  - Liste déroulante pour sélectionner un élève existant
  - Validation des données et des relations
  - Message de confirmation après création
  
- **Page de consultation des sanctions** (accessible uniquement si connecté)
  - Liste de toutes les sanctions avec leurs informations complètes
  - Affichage des informations liées (nom du professeur, nom de l'élève, classe de l'élève)
  - Interface claire et organisée
  - Design cohérent avec le reste de l'application
  
- **Amélioration de la base de données**
  - Ajout de la table `professeurs` avec les champs nécessaires
  - Ajout de la table `sanctions` avec les champs nécessaires et les clés étrangères
  - Vérification des contraintes d'intégrité référentielle
  
- **Repositories**
  - `professeurRepository.php` : gestion des professeurs (création, lecture)
  - `sanctionRepository.php` : gestion des sanctions (création, lecture)
  
- **Contrôleurs**
  - `professeurController.php` : logique de gestion des professeurs
  - `sanctionController.php` : logique de gestion des sanctions
  
- **Templates**
  - `templates/professeurs/create.php` : formulaire de création de professeur
  - `templates/sanctions/create.php` : formulaire de création de sanction
  - `templates/sanctions/index.php` : liste des sanctions
  
- **Interface de navigation enrichie**
  - Ajout des liens vers les nouvelles fonctionnalités dans le menu
  - Navigation cohérente entre toutes les pages

---

## 🧪 Tests et validations

| Fonctionnalité | Test attendu |
|----------------|--------------|
| Création de professeur | Ajouter un professeur avec nom, prénom et matière. Vérifier l'enregistrement en base de données. Tester la validation des champs obligatoires. |
| Création de sanction | Créer une sanction en sélectionnant un professeur et un élève existants. Vérifier l'enregistrement avec toutes les informations. Tester la validation des champs obligatoires et des relations. |
| Consultation des sanctions | Vérifier l'affichage de toutes les sanctions avec leurs informations complètes. Vérifier l'affichage des noms du professeur et de l'élève (pas seulement les IDs). |
| Validation des données | Tester la création avec des champs vides, des dates invalides, des sélections manquantes. Vérifier les messages d'erreur appropriés. |
| Intégrité référentielle | Vérifier qu'on ne peut pas créer une sanction avec un professeur ou un élève inexistant. |
| Interface | Vérifier la cohérence visuelle, la navigation fluide et l'accessibilité des nouvelles pages. |
| Sécurité | Vérifier que les pages sont protégées (accès uniquement si connecté). Vérifier la protection contre les injections SQL et XSS. |

---

## 🕒 Durée estimée
**2 semaines (Sprint 2)**  
Recommandation de découpage :
- **Semaine 1** : création de la table professeurs, US10 (création de professeur), création de la table sanctions
- **Semaine 2** : US13 (création de sanction), US16 (consultation des sanctions), amélioration de l'interface et validations

---

## ✅ Critères de fin de Sprint
- Un utilisateur connecté peut **créer un professeur** avec ses informations (nom, prénom, matière).  
- Un utilisateur connecté peut **créer une sanction** en associant un professeur et un élève existants.  
- Un utilisateur connecté peut **consulter la liste complète des sanctions** avec toutes les informations nécessaires.  
- La **base de données est cohérente** avec les nouvelles tables et les relations correctement définies.  
- Les **validations sont fonctionnelles** (champs obligatoires, intégrité référentielle).  
- L’interface est **claire, intuitive et cohérente** avec le design existant.  
- La **sécurité est assurée** (protection des pages, validation des données, requêtes préparées).

---

