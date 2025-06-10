<?php
session_start();
require_once '../includes/template.php';
settings('Login');
head();

if (isset($_POST['send'])){
$isUserFind = false;
$password=htmlspecialchars($_POST['password'] );
$name = htmlspecialchars($_POST['name'] );
$jsonFile = 'data/utilisateur.json';
$jsonData = file_get_contents($jsonFile);
$utilisateur = json_decode($jsonData, true);
echo"<pre>";
foreach($utilisateur as $user){
    if ($user["name"] == $name){
        if (password_verify($password, $user["motdepasse"])){
            $isUserFind = true;
            $_SESSION["pseudo"] = $user["utilisateur"];
            $_SESSION["mail"] = $user["email"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["vehicule"] = $user["vehicule"];
            $_SESSION["avatar"] = $user["avatar"];
            
            header("Location:../dashboard.php");
        }
        else{
            echo "<script type='text/javascript'>
            alert('mot de passe incorect');
            window.location.href = 'connexion.php';
          </script>";
          exit();
        }
    }
}
if (!$isUserFind) {
    echo "<script type='text/javascript'>
            alert('Informations incorrectes');
            window.location.href = 'connexion.php';
          </script>";
    exit();
}
}else{
    ?>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Connexion</h3>
        <form action="connexion.php" method="post" class="form-signin">
            <div class="mb-3">
                <label for="name" class="form-label">Nom d utilisateur :</label>
                <input type="text" name="user_name" id="name" class="form-control" placeholder="Votre nom d'utilisateur" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Votre mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
            </div>
            <button type="submit" name="send" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <br>
          <p class="text-center">Pas encore inscrit?<a href="inscription.php"> inscrivez-vous</a> </p>         
    </div>
</div>

</body>
</html>
<?php } ?>