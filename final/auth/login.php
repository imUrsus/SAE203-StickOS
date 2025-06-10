<?php
session_start();
require_once '../includes/template.php';
settings('Login');
head();

if (isset($_POST['send'])){
$isUserFind = false;
$password=htmlspecialchars($_POST['password'] );
$name = htmlspecialchars($_POST['user_name'] );
$jsonFile = '../data/users.json';
$jsonData = file_get_contents($jsonFile);
$utilisateur = json_decode($jsonData, true);

echo"<pre>";
foreach($utilisateur as $user){
    if ($user["username"] == $name){
        if (password_verify($password, $user["password"])){
            $isUserFind = true;
            $_SESSION["Lastname"] = $user["last_name"];
            $_SESSION["Firstname"] = $user["email"];
            $_SESSION["Role"] = $user["role"];
            $_SESSION["Photo"] = $user["Photo"];
            $_SESSION["Bio"] = $user["bio"];

            header("Location:../wiki.php");
        }
        else{
            echo "<script type='text/javascript'>
            alert('mot de passe incorect');
            window.location.href = 'login.php';
          </script>";
          exit();
        }
    }
}
if (!$isUserFind) {
    echo "<script type='text/javascript'>
            alert('Informations incorrectes');
            window.location.href = 'login.php';
          </script>";
    exit();
}
}else{
    ?>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Connexion</h3>
        <form action="login.php" method="post" class="form-signin">
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
