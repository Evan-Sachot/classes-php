<?php 
try{
$dbh = new PDO('mysql:host=Localhost;dbname=classes', 'root','');
} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}
class Userpdo {
 public $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct() {
        $this->id = null;
        $this->login = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
    }
     public function register($login, $password,$email, $firstname,$lastname){
        global $dbh;
        $stmt = $dbh->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) 
                           VALUES (:login, :password, :email, :firstname, :lastname)");
        $success = $stmt->execute([
        ':login' => $login,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':email' => $email,
        ':firstname' => $firstname,
        ':lastname' => $lastname
    ]);
    if($success){
       $id = $dbh->lastInsertId();
       $stmt = $dbh->prepare("SELECT* from utilisateurs where id = :id");
       $stmt->execute([':id'=> $id]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
        return null;
    }
    }
    public function connect($login, $password){
        global $dbh;
        $stmt = $dbh->prepare("SELECT * FROM utilisateurs WHERE login = :login AND password = '$password'");
        $success = $stmt->execute([':login' => $login, ':password' => $password]);
        if($success && $stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $data['password'])){
            $this->id = $data['id'];
             $this->login = $data['login'];
             $this->email = $data['email'];
             $this->firstname = $data['firstname'];
             $this->lastname = $data['lastname'];
             return true;
            }
            else {
                return false;
            }
        }
    }
     public function disconnect(){
        $this->id = null;
        $this->login = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
    }
    public function delete(){
        global $dbh;
        $stmt = $dbh->prepare("DELETE FROM utilisateurs WHERE id = $this->id");
        if($stmt->execute()){
            $this->disconnect();
            return true;
        }else{
            return false;
        }
        }
}



?>
