<?php 
try{
$dbh = new PDO('mysql:host=Localhost;dbname=classes', 'root','');
} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}
class Userpdo {
 public $sid;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

}
?>
