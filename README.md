# EPAKO
## Projet
Projet de fin de formation réalisé entre Mars et Avril 2021 en quasi autonomie (Nous pouvions consulter les formateurs en cas de problèmes techniques conséquents).

Epako : http://50.16.248.104/

Ce repository concerne la partie Back-end.

Documentation : https://github.com/juliencam/epako-back/tree/main/documentation
### Descriptif du projet
L'idée part du constat alarmant concernant le réchauffement climatique et du désastre environnemental causé par la surconsommation de masse. 

Le site se nomme Epako qui est une contraction de E-pas-commerce.

Le site se compose de deux faces distinctes : une partie e-commerce et une partie alternative.

Le site permet de comparer des produits du quotidien à empreinte écologique lourde avec des alternatives plus “saines” et éco-responsables.

L’utilisateur peut naviguer de l’une à l’autre par le switch au niveau de la navigation qui n’est pas visible à la première visite.

Le site imite les codes issus du e-commerce, mais n’en est pas réellement un. Aucun paiement n’est demandé, aucun achat ne peut être effectué.

L’utilisateur a l’opportunité de faire son shopping parmi une sélection de 6 catégories de plusieurs produits. À  la manière d’un site e-commerce, il peut remplir son panier.

L'utilisateur, lors de son premier passage, n'a pas connaissance du but final du site.
L’idée est de surprendre l’utilisateur en lui proposant des alternatives plus responsables, meilleures pour l'environnement, en essayant de trouver les produits voulus dans des associations, des magasins d’occasions, des applications de dons, des productions alimentaires locales, etc. Dans son département.

L’utilisateur fait son shopping, met au panier ses produits, s' il veut valider son panier, renseigné son département est obligatoire. La validation du panier déclenche le panier de comparaison qui lui propose des alternatives. Un texte d’explication est affiché à l’utilisateur. Les alternatives proposées sont liées aux sous-catégories de produits choisis et au département renseigné par l’utilisateur. Le switch qui était caché apparaît à présent. Il peut se rendre sur l’autre face du site qui est la partie alternative où il peut consulter les alternatives.

La partie alternative se compose également de 6 catégories. Ces catégories représentent les alternatives possibles de consommation. 

### Environnement :

Linux version 4.19.0-6-amd64

Visual Studio Code


### Technologies utilisées
#### Front

* React
* JSX
* Router-dom
* Axios
* Sass
* ClassNames
* Redux-persist 
* React-cookie 
* React-redux 

#### Back

* Symfony 5.2.6
* ORM Doctrine
* Mysql
* Adminer
* EasyAdminBundle3
* LexikJWTAuthenticationBundle
* NelmioCorsBundle
* VichUploaderBundle
* KnpPaginatorBundle
* Composer 
* Twig
* Bootstrap 
* PHPUnit
* Insomnia

### Outils utilisées
* Figma → pour la réalisation de l’arborescence ainsi que des wireframes
* Trello →  pour l’organisation du workflow et la mise en place de user Stories
* Mocodo → pour la réalisation du MCD
* Slack → pour la communication écrite et envoie de fichier
* Discord → pour la communication orale, écrite et partage d’écran
* Google Drive → partage de fichiers
* Git et Github→ Gestion de projet

### Equipe
* 3 développeurs front
* 2 développeurs back

### Méthode
* Agile Scrum (Temps de développement : 1 mois)

### Navigateur
L’application fonctionne correctement sur google chrome

## Conception et développement
* API Rest
* Back développé avec Symfony 5.2.6 
* Back Office développé avec le bundle Easy Admin 3 
* Front développé avec REACT
* Sécurité : Session et Access control (service symfony), LexikJWTAuthenticationBundle, NelmioCorsBundle
* Tests : PhpUnit (unitaire, fonctionnels)

