<?php 
    function start_page($pages): void
    {

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles/standard.css">

        <title><?php echo $pages[0]; ?></title>
    </head>
    <body>
        <header id="tender">
            <input type="button" id="ouvreBtn" class="menuBouton"/>
            <a id="ordre" class="headMenu" href="../modules/blog/controllers/views/<?php echo $pages[1]?>.php">l'<?php echo $pages[1]?></a>
            <a id="logo" class="headMenu" href="#"><img src="../images/logo4.png"/></a>
            <a id="compte" class="headMenu" href="views<?php echo $pages[2]?>.php"><img id="imgCompte" src="../images/compte1.png"></a>
        </header>
        <nav class="menu" id="menu">
            <input type="button" id="fermeBtn" class="menuBouton">
            <ul>
                <li><a href="#">Accueil</a></li>
            </ul>
        </nav>
    <?php
    }

    function end_page(): void
    {
        ?>
        <footer>

        </footer>
        <script>
            document.getElementById("ouvreBtn").onclick = ouverture;
            document.getElementById("fermeBtn").onclick = fermeture;
            var tender = document.getElementById("tender")
            var compte = document.getElementById("imgCompte");
            function ouverture(){
                menu.classList.add("ouvert");
                fermeBtn.classList.add("ouvert");
                ouvreBtn.classList.add("ouvert");
                tender.classList.add("ouvert");
                compte.style.visibility = "hidden"
            }
            function fermeture(){
                menu.classList.remove("ouvert");
                fermeBtn.classList.remove("ouvert");
                ouvreBtn.classList.remove("ouvert");
                tender.classList.remove("ouvert");
                compte.style.visibility = "visible"
            }
            window.onscroll = function() {
                if (window.pageYOffset > 50) {
                    tender.classList.add("ouvert");
                    compte.style.visibility = "hidden"
                } else {
                    tender.classList.remove("ouvert");
                    compte.style.visibility = "visible"
        }   
    };
            
        </script>
        </body>
        </html>
        <?php
    }
    ?>