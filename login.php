
<?php
    
    /* page: inscription.php */
//connexion à la base de données:
$BDD = array();
$BDD['host'] = "localhost";
$BDD['user'] = "root";
$BDD['pass'] = "";
$BDD['db'] = "monsite";
$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
if(!$mysqli) {
    echo "Connexion non établie.";
    exit;
}
    
$AfficherFormulaire=1;
//traitement du formulaire:
if(isset($_POST['email'],$_POST['mdp'],$_POST['username'])){
  //l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
    if(empty($_POST['email'])){//le champ pseudo est vide, on arrête l'exécution du script et on affiche un message d'erreur
        echo "Le champ email est vide.";
    } elseif(!preg_match("#^[a-z0-9]+$#",$_POST['email'])){
        echo "Le email doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
    } elseif(strlen($_POST['email'])>25){//le pseudo est trop long, il dépasse 25 caractères
      echo "Le email est trop long, il dépasse 25 caractères.";
    }elseif(empty($_POST['username'])){//le champ mot de passe est vide
        echo "Le champ Mot de passe est vide.";
        
    } elseif(empty($_POST['mdp'])){//le champ mot de passe est vide
        echo "Le champ Mot de passe est vide.";
    } elseif(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM `login` WHERE email='".$_POST['email']."'"))==1){//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
        echo "Ce email est déjà utilisé.";
    } else {
       
        if(!mysqli_query($mysqli,"INSERT INTO `login` SET email='".$_POST['email']."', mdp='".md5($_POST['mdp'])."', username='".($_POST['username'])."'")){//on crypte le mot de passe avec la fonction propre à PHP: md5()
            echo "Une erreur s'est produite: ".mysqli_error($mysqli);//je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
        } else {
            echo "Vous êtes inscrit avec succès!";
            //on affiche plus le formulaire
            $AfficherFormulaire=0;
        }
    }
}
if($AfficherFormulaire==1){
  
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="profil.php">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Connexion </a>
        </li>

      </ul>
    </div>
  </div>
</nav>


  <div class="form">
    <br />
    <form method="post" action="login.php">
       email : <input type="email" name="email">
        <br />    
         username : <input type="text" name="username">
        <br />
        Mot de passe : <input type="password" name="mdp">
        <br />

        confirmer password : <input type="text" name="">
        <br /><br>
        <input type="submit" value="S'inscrire">
    </form>
    <?php
  }
  ?>
</div>
</body>
</html>
