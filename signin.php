<?php

$errors = [];
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username !== 'toto' || $password !== '1234') {
        $errors[] = 'Identifiant ou mot de passe invalid';
    } else {
        header('Location: index.php');
    }
}
?>
<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signin</title>
</head>
<body>
    <?php if (!empty($errors)) : ?>
        <div class="errors">
            <?php foreach ($errors as $err) : ?>
                <div><?php echo $err; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="signin.php" method="POST">
        <div>
            <input type="text" name="username" placeholder="Identifiant">
        </div>
        <div>
            <input type="password" name="password" placeholder="Mot de Passe">
        </div>
        <input type="submit">
    </form>

</body>
</html>
