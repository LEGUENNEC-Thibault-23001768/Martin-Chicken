<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Vues/assets/main.css">
</head>
<body>
    <h2>Login</h2>
    <form action="index.php?ctrl=Login&action=login" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <?php if (isset($A_vue['error'])): ?>
        <p style="color: red;"><?php echo $A_vue['error']; ?></p>
    <?php endif; ?>
</body>
</html>
