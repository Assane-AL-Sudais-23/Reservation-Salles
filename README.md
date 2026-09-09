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


