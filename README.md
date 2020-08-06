# XML_APP


Applications requis pour le fonctionnement de l'application

1 - COMPOSER (https://getcomposer.org/Composer-Setup.exe) --> Pour la gestion des dépendances PHP 

2 - Wampserver --> Pour la base de donnée SQL et le serveur Apache
(Vous pouvez utiliser des alternatives à ces applications comme EasyPHP et Mysql Workbench)

3 - Télécharger le dossier du projet Github "application"

4 - Télécharger le fichier "database.sql" dans le repertoire Github

Etapes de configuration du projet

1 - Télecharger et installer COMPOSER avec les paramètres par défauts
2 - Télecharger et installer WAMPSERVER avec les paramètres par défauts
3 - Copier le dossier "application" téléchargé depuis le répertoire github dans le dossier www au chemin C:\wamp64\www (Sous Windows 10)
4 - Accéder en ligne de commande au répertoire précédemment copier donc normalement "C:\wamp64\www\application" puis exécuter la commande "composer install"
5 - Lancer l'application WAMPSERVER (Vous devrier avoir un insigne qui passera du rouge au vert dans la barre des tâches)
6 - Cliqueer sur l'insigne vert et cliquer sur phpMyAdmin
7 - Connecter vous avec le login par défaut "root" (Il n'y a pas de mot de passe requis) 
8 - Créer la base de donnée en important le fichier "database.sql" précédemment téléchargé (veuillez suivre cette vidéo pour cela --> https://www.youtube.com/watch?v=jW5lrS6EUPM)



DANS LE CAS OU VOUS AVEZ DEJA WAMPSERVER (Faites toutes les étapes précédentes sauf l'étape 2) veuillez reconfigurer le fichier DBAccess.php (si nécéssaire) se trouvant à C:\wamp64\www\application\src\configs
Vous devrer modifier les lignes :

private $login="Votre Login";
private $password="Votre Mot de passe";
	
	Remplacer << Votre Login par votre >> login actuel si ce n'est pas celui par défaut
	Remplacer << Votre Mot de passe >> par votre mot de passe actuel si ce n'est pas celui par défaut
