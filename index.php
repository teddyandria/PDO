<?php

require_once 'connec.php';

//on se connecte à la base de donné
$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($friendsArray);

foreach ($friendsArray as $friend) {
    echo $friend['firstname'] . ' ' . $friend['lastname'] . ' ';
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nakama = array_map('trim', $_POST);

    if (empty($nakama['firstname'])) {
        $errors[] = 'Le prénom est obligatoire.';
    }

    $maxFirstnameLength = 45;
    if (strlen($nakama['firstname']) > 45) {
        $erros[] = 'Le prénom doit faire moins de ' . $maxFirstnameLength . ' caractères.';
    }

    $maxLastnameLength = 45;
    if (strlen($nakama['lastname']) > 45) {
        $erros[] = 'Le nom doit faire moins de ' . $maxLastnameLength . ' caractères.';
    }


    if (empty($nakama['lastname'])) {
        $errors[] = 'Le nom est obligatoire.';
    }


    if (empty($errors)) {

        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $nakama['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $nakama['lastname'], PDO::PARAM_STR);
        $statement->execute();

        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire Friends</title>
</head>

<body>


    <form action="" method="POST">

        </ul>
        <label for="firstname">Firstname</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Lastname</label>
        <input type="text" id="lastname" name="lastname" required>

        <button>Envoyer</button>

    </form>


</body>

</html>