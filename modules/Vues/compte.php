<link rel="stylesheet" href="Vues/assets/compte.css">

<?php if (AuthModel::isLoggedIn()): ?>
    <div id="utile">
        <div id="boutonsControleur">
            <button class="btns" onclick="loadLister('Plat')">Plats</button>
            <button class="btns" onclick="loadLister('Repas')">Repas</button>
            <button class="btns" onclick="loadLister('Structure')">Structure</button>
            <button class="btns" onclick="loadLister('Tenrac')">Tenrac</button>
        </div>
        <div id="injection">

        </div>
    </div>
<?php else: ?>
    <div id="utile">
        <div id="cadre">
        <h2>Connection</h2>
        <form action="?ctrl=Compte&action=login" method="POST">
            
            <section class="eleForm">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
            </section>
            
            <section class="eleForm">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </section>
            
            <section class="eleForm">
                <a href="#">Mot de passe oublié ?</a>
            </section>
            
            <section class="eleForm">
                <button type="submit" class="login-btn">Se connecter</button>
            </section>
        </form>
    </div>
        <?php if (isset($A_vue['error'])): ?>
        <p style="color: red;"><?php echo $A_vue['error']; ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<script>
    function loadLister(controller) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '?ctrl='+controller, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(xhr.responseText, 'text/html');
            const section = doc.querySelector('section');
            const combinedHTML = (section ? section.outerHTML : '');
            document.getElementById('injection').innerHTML = combinedHTML;
        }
    };
    xhr.send();
    }
    function loadAjouter(controller) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '?ctrl='+controller+'&action=ajouter', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(xhr.responseText, 'text/html');
            const form = doc.querySelector('form');
            const link = doc.querySelector('link');
            const combinedHTML = (link ? link.outerHTML : '')+
                                (form ? form.outerHTML : '');
            document.getElementById('injection').innerHTML = combinedHTML;
        }
    };
    xhr.send();
    }
    function loadSupprimer(controller) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '?ctrl='+controller+'&action=supprimer', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('injection').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
    }
    function loadModifier(controller, id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '?ctrl='+controller+'&action=modifier&id='+id, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('injection').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
    }
</script>