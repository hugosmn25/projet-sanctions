# 📘 Product Backlog – Gestion des sanctions (Lycée)

## 📋 Format des User Stories

Chaque user story est formulée selon le format :  
**En tant que [rôle], je veux [objectif], afin de [bénéfice attendu].**

---

## 🎯 Épic 1 : Authentification et gestion des utilisateurs

### US1 – Authentification 
**En tant que** personnel de vie scolaire, **je veux** m'authentifier avec un identifiant et un mot de passe, **afin d'** accéder à l'application de manière sécurisée.

### US2 – Création d'utilisateur 
**En tant que** personnel de vie scolaire, **je veux** créer mon propre compte utilisateur, **afin de** pouvoir accéder à l'application sans intervention d'un administrateur.

### US3 – Modification/Suppression d'utilisateur
**En tant que** personnel de vie scolaire connecté, **je veux** modifier ou supprimer un compte utilisateur, **afin de** maintenir la liste des personnels autorisés.

### US4 – Déconnexion
**En tant qu'** utilisateur connecté, **je veux** pouvoir me déconnecter, **afin de** sécuriser ma session.

### US25 – Dashboard utilisateur
**En tant que** personnel de la vie scolaire connecté
**Je veux** accéder à une page d’accueil (Dashboard) après ma connexion
**Afin de** visualiser les informations principales et naviguer facilement vers les différentes fonctionnalités de l’application

---

## 🏫 Épic 2 : Gestion des classes et des élèves

### US5-1 – Création de classe 
**En tant que** personnel de vie scolaire connecté, **je veux** créer une classe, **afin d'**organiser les élèves.

### US5-2 – Consultation de la liste des classes 
**En tant que** personnel de vie scolaire connecté, **je veux** consulter la liste des classes, **afin de** voir toutes les classes de l'établissement.

### US6 – Modification/Suppression de classe
**En tant que** personnel de vie scolaire connecté, **je veux** modifier ou supprimer une classe existante, **afin de** garder la base à jour.

### US7-1 – Création d'élève
**En tant que** personnel de vie scolaire connecté, **je veux** créer un élève avec ses informations (nom, prénom, date de naissance, classe), **afin de** l'intégrer au système.

### US7-2 – Consultation de la liste des élèves
**En tant que** personnel de vie scolaire connecté, **je veux** consulter la liste des élèves, **afin de** voir tous les élèves de l'établissement.

### US8 – Modification/Suppression d'élève
**En tant que** personnel de vie scolaire connecté, **je veux** modifier ou supprimer les informations d'un élève, **afin de** corriger ou supprimer ses données.

### US9 – Consultation et filtrage des élèves
**En tant que** personnel de vie scolaire connecté, **je veux** consulter la liste des élèves et filtrer par classe, **afin de** retrouver rapidement un élève.

---

## 👨‍🏫 Épic 3 : Gestion des professeurs

### US10 – Création de professeur
**En tant que** personnel de vie scolaire connecté, **je veux** créer un professeur avec ses informations (nom, prénom, matière), **afin de** pouvoir l'associer à une sanction.

### US11 – Modification/Suppression de professeur
**En tant que** personnel de vie scolaire connecté, **je veux** modifier ou supprimer un professeur, **afin de** maintenir la base à jour.

### US12 – Consultation des professeurs
**En tant que** personnel de vie scolaire connecté, **je veux** consulter la liste des professeurs, **afin d'** en sélectionner un lors de la création d'une sanction.

---

## ⚖️ Épic 4 : Gestion des sanctions

### US13 – Création de sanction
**En tant que** personnel de vie scolaire connecté, **je veux** créer une sanction en précisant la date, le motif, le type, le professeur et l'élève concerné, **afin d'** enregistrer un incident.

### US14 – Modification de sanction
**En tant que** personnel de vie scolaire connecté, **je veux** modifier une sanction existante, **afin de** corriger une erreur.

### US15 – Suppression de sanction
**En tant que** personnel de vie scolaire connecté, **je veux** supprimer une sanction, **afin de** retirer un enregistrement obsolète.

### US16 – Consultation des sanctions
**En tant que** personnel de vie scolaire connecté, **je veux** consulter la liste des sanctions, **afin d'** en assurer le suivi.

### US17 – Filtrage des sanctions
**En tant que** personnel de vie scolaire connecté, **je veux** filtrer les sanctions par élève, classe, type ou date, **afin d'** affiner mes recherches.

---

## 📊 Épic 5 : Consultation et suivi

### US18 – Historique des sanctions d'un élève
**En tant que** personnel de vie scolaire connecté, **je veux** rechercher un élève et consulter l'historique complet de ses sanctions, **afin de** suivre son comportement.

### US19 – Export/Impression des sanctions
**En tant que** personnel de vie scolaire connecté, **je veux** imprimer ou exporter la liste des sanctions, **afin de** préparer des réunions ou rapports *(fonctionnalité optionnelle)*.

---

## 🔒 Épic 6 : Ergonomie

### US0 – Page d’accueil
**En tant qu’** utilisateur (personnel ou visiteur), **je veux** accéder à une page d’accueil claire et informative,
**afin de** comprendre la finalité de l’application et choisir entre la connexion ou la création de compte.

(Page publique orientant vers US1 et US2.)

### US21 – Interface intuitive 
**En tant qu'** utilisateur, **je veux** une interface claire et intuitive, **afin d'** effectuer les opérations courantes sans difficulté.

---

## 🚀 Épic 7 : Évolutions futures *(non prioritaires)*

### US22 – Envoi d'emails automatiques
**En tant que** personnel vie scolaire, **je veux** pouvoir envoyer un e-mail automatique aux parents lors de la création d'une sanction.

### US23 – Statistiques globales
**En tant que** chef d'établissement, **je veux** consulter des statistiques globales sur les sanctions, **afin d'** analyser le comportement des élèves.

### US24 – Intégration avec logiciel existant
**En tant qu'** administration, **je veux** pouvoir intégrer l'application avec le logiciel de gestion des élèves existant, **afin d'** éviter la double saisie.

