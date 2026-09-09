# Quel est le rôle de Composer ?
    c'est un gestionnaires de dependances qui permet d'installer les bonnes versions de dependances et 
    génére un fichier automatique qui permet d'utiliser toutes ces bibliotheques

# Quelle différence existe entre require et require-dev ?
    Require importe les outils necessaires pour le fonctionnement de l'application tandisque Require-dev
    importe les outils dont on a besoin pour developper l'application

# Pourquoi faut-il versionner composer.lock ?
    C'est pour garantire aux autres developpeurs utilisant ce projet et le serveur de production d'utiliser
    les memes versions de bibliotheques

# Pourquoi ne versionne-t-on pas vendor/ ?
    Ce dossier comporte du code généré qui est lourd 

# Quel rôle joue Capsule\Manager ?
    Il nous permet de manipuler la base de donnee sans faire de requete ni utiliser des framework

# Pourquoi Eloquent peut-il fonctionner sans Laravel ?
    Eloquent est un package independant et geres ces propres dependances

# Où doit se trouver le démarrage de l’ORM ?
    Il doit se trouver dans public/index.php le point d'entree de l'application

# Quelle différence existe entre ORM et SQL écrit à la main ?
    Avec ORM on manipule des objet qui traduit les action en requetes SQL hors ecrit SQL a la main interagit 
    directe avec la base

# Quel type de relation Eloquent avez-vous utilisé ?
    Il s'agit de la relation one-to-many, une salle peut avoir plusieurs reservation

# Pourquoi déclarer $fillable ou $guarded ?
    avec fillable on definit les champs a saisir avec guarded on definis les champs a proteger

# Pourquoi convertir active en booléen ?
    pour eviter de comparer avec des entier en chaines 
# Pourquoi convertir les dates en objets ?
    Convertir les dates en objet donne la possibilite de manipuler des methodes comme le format date

# Quelle différence existe entre migration et seeder ?
    Les migrations construisent la structures et les seeders remplissents les tables

# Pourquoi les données initiales doivent-elles être reproductibles ?
    Pour garantier les test automatises fiables

# Comment empêcher les doublons ?

# Pourquoi séparer la validation syntaxique des règles métier ?
Les regles metier peut variables si on ne les separer pas quand les changer on risque de toucher entierrement les classes validation

# Pourquoi créer une interface de validation ?
    c'est pour eviter une couplage forte entre deux classe et faire evolution a l'extension

# Pourquoi le validateur ne doit-il pas enregistrer les données ?
    c'est pas son tache le validateur doit s'occuper a gerer la validation des donnees pour respecter le principe de S de SOLID

# Comment retourner plusieurs erreurs en une seule fois ?

# Quelle différence existe entre DTO et modèle Eloquent ?
    Un DTO est un simple conteneur de donnees alors un model Eloquent est une entité liée a la base de données

# Pourquoi le DTO ne doit-il pas appeler save() ?
    Son role est de transporter les donner sinon il viole la principe du S de SOLID

# À quel moment transforme-t-on les chaînes en dates ?
    A la reception du controller avec $POST des donnes venant d'un formulaire ou s'il doivent etre persister en BDD

# Le DTO doit-il contenir la règle de chevauchement ?

# Eloquent constitue-t-il déjà un accès aux données ?
    Oui Eloquent est une couche aux acces de donnees

# Pourquoi ajouter un Repository au-dessus d’Eloquent ?
    c'est pour eviter une dependance forte 

# Cette abstraction est-elle toujours nécessaire ?
    Non Elequent n'est pas du SQL seulement
    
# Quel avantage apporte-t-elle ?

# Pourquoi ces règles ne sont-elles pas dans le contrôleur ?
    Le role du controller est de gerer les vues et d'intercepter les requetes si on la donne les regles metier le principe du S de SOLID est violé

# Pourquoi le service dépend-il d’une interface de Repository ?
    C'est pour eviter le couplage fort et applique la Dependancy Inversion principle

# Quelle exception doit être levée en cas de conflit ?

# Comment tester le service sans MySQL ?

# Pourquoi FastRoute ne construit-il pas lui-même le contrôleur ?
    La seule et unique responsabilite du FastRouter est d'analyser l'URL demander ainsi que les methodes http(POST, GET)

# Quelle différence existe entre 404 et 405 ?
    404 indique l'url n'existe pas tandis que 405 indique l'url existe mais la methode n'est pas autoriser

# Pourquoi contraindre {id} avec \d+ ?

# Quel composant doit interpréter le handler retourné ?
    C'est le dispatcher charge et execute le handler

# Quelle différence existe entre injection et conteneur ?
    l'injection est un principe tandis que le conteneur est un outils qui automatise ce principe

# Qu’est-ce que l’autowiring ?
    C'est une fonctionnalité d'un conteneur d'injection de dépendances qui permet de résoudre et d'instancier automatiquement les dépendances d'une classe

# Pourquoi les interfaces nécessitent-elles une définition ?
    les interfaces sont des contrat abstract, ils ne sont pas instanciable 

# Pourquoi limiter $container->get() au point d’entrée ?

# Quel anti-pattern apparaît si toutes les classes interrogent le conteneur ?

