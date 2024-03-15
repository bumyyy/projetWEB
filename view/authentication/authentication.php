<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Stage_tier</title>
</head>
<body>
    
    <div class="container">
        <div class="gauche">
            <div class="titre">
                <h1>Stage_tier</h1>
            </div>

            <div class="logo">
                <img src="/../assets/logo.png" alt="LOGO">
            </div>
        </div>

        <div class="milieu">
            <div class ="separator"></div>
        </div>

        <div class="droite">
            <div class="titredroite">
                <h2>S'identifier</h2>
            </div>
            
            <form id="login" method="POST">
                <div class="champemail">
                    <input type="email" id="mail" name="mail" placeholder="Email" required>
                </div>
                <div class="champmdp">
                    <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>
                </div>
           

                <div class="check">
                    <input type="checkbox" id="showPassword" onclick="toggleVisibility()">
                    <label for="showPassword">Afficher le mot de passe</label>
                </div>
                    
                <button type="submit" class="bouton">Identification</button>
            </form>
            <br>
            <br>
            <div id="errorMessage" style="color: red; display: none;">Mail ou mot de passe incorrect.</div>

            </div>
            

        </div>
    </div>
    
<!-- JAVASCRIPT MDP -->
<script>
    function toggleVisibility() {
        var mdpInput = document.getElementById("mdp");
        if (mdpInput.type === "password") {
            mdpInput.type = "text";
        } else {
            mdpInput.type = "password";
        }
    }
</script>

<script src = "verifierLogin.js"></script>

</body>
</html>