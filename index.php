<?php
require_once 'connect.php';

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);

$friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<ul><?php
    foreach($friendsArray as $friend) {
        echo '<li>'. $friend['firstname'] . ' ' . $friend['lastname'] . '</li>';
    }
    ?>
</ul>


    <form action="/index.php" method="post">
      <div>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" />
      </div>
      <div>
        <label for="firstname">Prénom :</label>
        <input type="text" id="nom" name="firstname"  />
      </div>
      <div class="button">
        <button type="submit">Envoyer votre message</button>
      </div>
    </form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') // Appliquer le code si method POST envoyée
{
    if (trim(($_POST['firstname']) === '') && ((isset($_POST['firstname'])) == true)) // Vérif pour le prénom
    {
        echo "Erreur, vous devez donner un prénom";
        die();
    }
    if (trim(($_POST['lastname']) === '') && ((isset($_POST['lastname'])) == true)) // Vérif pour le nom
    {
        echo "Erreur, vous devez donner un nom";
        die();
    }

    $firstname = trim($_POST['firstname']); 
    $lastname = trim($_POST['lastname']);

    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $statement->execute();
    header('Location: /');

}



