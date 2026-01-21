<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px #aaa; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; border: none; border-radius: 5px; background: #4CAF50; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>
        <form action="traitement_login.php" method="POST">
            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
