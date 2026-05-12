# 🚪 **US4 – Déconnexion utilisateur**

## 🎯 **Titre / Objectif**

> **En tant que** utilisateur connecté (personnel de la vie scolaire)
> **Je veux** pouvoir me déconnecter de l’application
> **Afin de** garantir la confidentialité de mes informations et éviter qu’un autre utilisateur accède à mon espace

---

## 🔍 **Description**

Cette User Story permet à un membre du personnel de **quitter son espace personnel** en toute sécurité.
Un bouton ou un lien de déconnexion doit être visible à tout moment dans l’application.

Lorsqu’il clique dessus, l’utilisateur doit être **clairement informé qu’il a bien quitté son espace**, et il doit **revenir sur la page de connexion**.
Cela évite qu’une autre personne utilise son poste pour accéder à ses informations.

---

## ✅ **Critères d’acceptation**

### **CA1 – Bouton ou lien de déconnexion**

* L’utilisateur voit un bouton **“Déconnexion”** lorsqu’il est connecté.
* Ce bouton est disponible depuis toutes les pages internes de l’application.
* Son libellé est clair et conforme à la charte graphique.

---

### **CA2 – Fermeture du compte en cours**

* Lorsqu’il clique sur “Déconnexion”, l’utilisateur quitte son espace personnel.
* Il ne peut plus accéder aux pages internes sans se reconnecter.

---

### **CA3 – Redirection**

* Après la déconnexion, l’utilisateur revient automatiquement sur la **page de connexion**.
* Un message clair confirme qu’il s’est bien déconnecté (ex. : “Vous êtes maintenant déconnecté”).

---

### **CA4 – Expérience utilisateur**

* Le parcours “Connexion → Déconnexion” est simple et cohérent.
* Le retour visuel (message + redirection) est rapide et compréhensible.

---

## 📊 **Règles métier**

| Élément         | Règle fonctionnelle                                                     |
| --------------- | ----------------------------------------------------------------------- |
| **Déconnexion** | Accessible à tout moment depuis l’espace utilisateur.                   |
| **Accès**       | Interdit aux utilisateurs non connectés.                                |
| **Sécurité**    | L’utilisateur doit toujours savoir quand il est connecté ou déconnecté. |

---

## ⏱️ **Estimation**

* **Complexité** : Faible
* **Story Points** : 2
* **Priorité** : ★★★ (Critique – Sprint 1 ou 2 selon planification)

---

## 📌 **Dépendances**

* **US1 – Connexion utilisateur** : il faut qu’un utilisateur puisse être connecté pour se déconnecter.

---

## 👥 **Parties prenantes**

| Rôle                                 | Responsabilité                                                       |
| ------------------------------------ | -------------------------------------------------------------------- |
| **Product Owner**                    | Définit le comportement attendu et valide la simplicité du parcours. |
| **Équipe de développement**          | Réalise le bouton et la logique de retour à la page de connexion.    |
| **Utilisateur final (vie scolaire)** | Teste la clarté et la facilité d’utilisation de la déconnexion.      |

---

## ✅ **Définition de “Terminé” (Definition of Done)**

* Le bouton “Déconnexion” est visible et fonctionne sur toutes les pages internes.
* L’utilisateur revient automatiquement sur la page de connexion.
* Un message confirme la déconnexion.
* Le parcours est validé par le Product Owner lors de la revue de sprint.

---

## 🧭 **Résumé fonctionnel**

> Cette fonctionnalité permet de **protéger les données** des utilisateurs en leur donnant la possibilité de quitter facilement leur session, de manière claire, rapide et sécurisée.





