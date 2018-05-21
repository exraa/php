<?php  
require 'recaptchalib.php';
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se connecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  // est-on au 1er appel du programme ou non ?
  $etape=(count($_POST)!=0)?'validerConnexion' : 'demanderConnexion';
//count — Compte tous les éléments d'un tableau ou quelque chose d'un objet
// S'il n'y a aucun POST envoyé, demander à se connecter.
  


$siteKey = '6LfNfloUAAAAAAgTWuiHiDQYP38sJcnXksI4mrgQ'; // votre clé publique
$secret = '6LfNfloUAAAAANuKGXOLid8qpFd_1tgXHz_ZGUMd'; // votre clé privée




$reCaptcha = new ReCaptcha($secret);
if(isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
        );
    }



  if ($etape=='validerConnexion' && $resp != null && $resp->success) { // un client demande à s'authentifier
      // acquisition des données envoyées, ici login et mot de passe
      $login = lireDonneePost("txtLogin");
      $mdpd = lireDonneePost("txtMdp"); 
      $mdp = openssl_digest ("$mdpd", "sha256");  
      $lgUser = verifierInfosConnexion($idConnexion, $login, $mdp) ;
      // si l'id utilisateur a été trouvé, donc informations fournies sous forme de tableau
      if ( is_array($lgUser) ) { 
          affecterInfosConnecte($lgUser["id"], $lgUser["login"]);
      }
      else {
          ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
      }
  }
  if ( $etape == "validerConnexion" && nbErreurs($tabErreurs) == 0 ) {
        header("Location:index.php");
  }

  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Identification utilisateur</h2>
<?php

          if ( $etape == "validerConnexion" ) 
          {
              if ( nbErreurs($tabErreurs) > 0 ) 
              {
                echo toStringErreurs($tabErreurs);
              }
          }
?>               
      <form id="frmConnexion" action="" method="post">
      <div class="corpsForm">
        <input type="hidden" name="etape" id="etape" value="validerConnexion" />
      <p>
        <label for="txtLogin" accesskey="n">* Login : </label>
        <input type="text" id="txtLogin" name="txtLogin" maxlength="20" size="15" value="" title="Entrez votre login" />
      </p>
      <p>
        <label for="txtMdp" accesskey="m">* Mot de passe : </label>
        <input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value=""  title="Entrez votre mot de passe"/>
      </p>
      </div>
      <div class="piedForm">
      <p>
      	<div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        <input type="submit" id="ok" value="Valider" />
        <input type="reset" id="annuler" value="Effacer" />
      </p> 
      </div>
      </form>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>