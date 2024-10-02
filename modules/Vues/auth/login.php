<div id="cadre">
    <h2>Connection</h2>
    <form action="?ctrl=Compte&action=login" method="post">
        
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