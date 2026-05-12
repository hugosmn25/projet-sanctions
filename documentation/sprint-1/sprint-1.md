# 🏁 Détail du Sprint 1 – Projet "Gestion des sanctions"

## 🎯 Objectif du Sprint 1
Mettre en place les fondations de l’application :  
authentification, création de compte utilisateur, gestion de base des classes et des élèves.  
L’objectif est d’obtenir une première version fonctionnelle permettant à un personnel de la vie scolaire de se connecter, de créer son compte, et de gérer les premières données.

---

## 🔧 User Stories incluses

| ID | User Story | Priorité | Critères d’acceptation |
|----|-------------|-----------|------------------------|
| **US0** | En tant que personnel de la vie scolaire, je veux accéder à une page d’accueil claire et informative pour comprendre la finalité de l’application et choisir entre la connexion ou la création de compte. | ★ | Page accessible publiquement via l’URL racine. |
| **US1** | En tant que personnel de vie scolaire, je veux m'authentifier avec un identifiant et un mot de passe pour accéder à l'application. | ★ | L’accès est refusé sans connexion. Authentification valide. Message d’erreur si identifiants invalides. |
| **US2** | En tant que personnel de vie scolaire, je veux créer mon propre compte utilisateur afin d'accéder à l'application sans intervention d'un administrateur. | ★ | Formulaire complet (nom, prénom, identifiant, mot de passe). L’utilisateur est ajouté et peut se connecter immédiatement. |
| **US4** | En tant qu’utilisateur connecté, je veux pouvoir me déconnecter. | ★ | La session est détruite. L’utilisateur est redirigé vers la page de connexion. |
| **US5-1** | En tant que personnel de vie scolaire connecté, je veux créer une classe afin de pouvoir y associer des élèves. | ★ | Le formulaire d'ajout permet d'enregistrer le nom et le niveau. La classe apparaît dans la liste après validation. |
| **US5-2** | En tant que personnel de vie scolaire connecté, je veux consulter la liste des classes pour voir toutes les classes de l'établissement. | ★ | La liste affiche toutes les classes avec leur nom, niveau et date de création. Interface claire et navigation fluide. |
| **US7-1** | En tant que personnel de vie scolaire connecté, je veux créer un élève et l'associer à une classe existante. | ★ | Le formulaire permet d'ajouter un élève (nom, prénom, date de naissance, classe). L'élève est enregistré avec succès. |
| **US7-2** | En tant que personnel de vie scolaire connecté, je veux consulter la liste des élèves pour voir tous les élèves de l'établissement. | ★ | La liste affiche tous les élèves avec leurs informations (nom, prénom, classe, date de naissance). Interface claire et navigation fluide. |
| **US20** | En tant que développeur, je veux que les mots de passe soient stockés de manière sécurisée. | ★ | Les mots de passe sont hachés en base de données. La vérification du mot de passe fonctionne à la connexion. |
| **US21** | En tant que personnel de vie scolaire connecté, je veux disposer d'une interface claire et intuitive. | ★ | Navigation fluide entre connexion, création de compte, classes et élèves. Interface simple et lisible. |
| **US25** | En tant que personnel de vie scolaire connecté, je veux accéder à une page d’accueil (Dashboard) après ma connexion. | ★ | Navigation facilité vers les différentes fonctionnalités de l’application

---

## 🧩 Livrables attendus

- **Page d'accueil** (accessible à tous)  
- **Page de création de compte utilisateur** (nom, prénom, identifiant, mot de passe)  
- **Page de connexion** (formulaire + vérification)  
- **Page de déconnexion** (fin de session + redirection)  
- **Page de création de classe** (accessible uniquement si connecté)  
- **Page de consultation des classes** (accessible uniquement si connecté)  
- **Page de création d'élève** (accessible uniquement si connecté)  
- **Page de dashboard** (accessible uniquement si connecté)  
- **Page de consultation des élèves** (accessible uniquement si connecté)  
- **Base de données initiale** (tables : utilisateurs, classes, élèves)  
- **Interface de navigation minimale** entre les différentes pages  

---

## 🧪 Tests et validations

| Fonctionnalité | Test attendu |
|----------------|--------------|
| Création de compte | Saisie d’un nouvel utilisateur et vérification que la connexion fonctionne. |
| Dashboard | Vérifier affichage du message de bienvenue, accès aux modules, bouton de déconnexion. |
| Authentification | Test de connexion avec identifiants valides et invalides. Accès refusé sans session active. |
| Déconnexion | Vérifier que l’accès aux pages protégées est bloqué après déconnexion. |
| Création de classe | Ajouter une ou plusieurs classes et vérifier leur présence dans la liste. |
| Consultation des classes | Vérifier l'affichage de toutes les classes avec leurs informations. |
| Création d'élève | Ajouter un élève dans une classe et vérifier son enregistrement. |
| Consultation des élèves | Vérifier l'affichage de tous les élèves avec leurs informations. |
| Sécurité | Vérifier que les mots de passe ne sont pas stockés en clair en base. |

---

## 🕒 Durée estimée
**2 semaines (Sprint 1)**  
Recommandation de découpage :
- **Semaine 1** : création de compte, authentification, déconnexion, sécurisation des mots de passe  
- **Semaine 2** : gestion des classes et élèves, finalisation de la navigation et de l’interface

---

## ✅ Critères de fin de Sprint
- Un utilisateur vie scolaire peut créer un compte et se connecter.  
- L’accès aux pages de gestion est restreint aux utilisateurs connectés.  
- Les élèves peuvent être créés et consultés par un utilisateur connecté.  
- Les mots de passe sont stockés de manière sécurisée (hash).  
- L’interface est claire et fonctionnelle.

---
