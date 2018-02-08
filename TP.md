# TP CleanCode

Avant de commencer les exercices, il est conseiller de faire un peu de revue de code.

## PHPUnit

### BankAccount

L'objectif ? Créer une classe offrant la possibilité de gérer un compte bancaire avec les opérations basique comme déposer de l'argent ou en retirer.

Il est obligatoire de vérifier le montant du dépôt ou du retrait.

En respectant le principe du TDD (Test-Driven Developpment), créez une classe nommée BankAccount dans laquelle il faudra implémenter les méthodes suivantes :

- increase
- decrease

---

### ProductRepository

En respectant le principe du TDD (Test-Driven Developpment), il faut ajouter les méthodes permettant d'interagir avec des produits dans une base de données.

L'exercice consiste à implémenter par le biais de tests les méthodes suivantes dans la classe ProductRepository :

- findOne
- findAll
- create
- update
- delete

Une fois les tests terminés, assurez-vous de ne rien avoir oublié avec le CodeCoverage.
