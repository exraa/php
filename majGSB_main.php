 Programme d'actualisation des lignes des tables,  
 cette mise à jour peut prendre plusieurs minutes...
<?php
include("include/_entete.inc.html");
/*include("include/_init.inc.php");*/
include("include/fct.inc.php");

/* Modification des paramètres de connexion */

$serveur='mysql:host=localhost';
$bdd='dbname=gsb_php';   		
$user='root' ;    		
$mdp='root' ;	

/* fin paramètres*/

$pdo = new PDO($serveur.';'.$bdd, $user, $mdp);
$pdo->query("SET CHARACTER SET utf8"); 

set_time_limit(0);
creationFichesFrais($pdo);
creationFraisForfait($pdo);
creationFraisHorsForfait($pdo);
majFicheFrais($pdo);
include("include/_pied.inc.html");

?>