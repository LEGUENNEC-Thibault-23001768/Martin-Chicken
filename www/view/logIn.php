<?php

echo <<<HTML
<form action="/logIn" method="post">
    <label for="name">Pseudo:</label>
    <input type="text" id="name" name="name" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Log In</button>
</form>
HTML;
