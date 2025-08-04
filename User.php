<?php
$conn = new mysqli("localhost", "root", "", "classes");
class User {
    public $sid;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public function __construct() {
        $this->sid = null;
        $this->login = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
    }
    public function register($login, $password,$email, $firstname,$lastname){
        global $conn;
        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')";
        if($conn->query($sql)){
            $id = $conn -> insert_id;
            $result = $conn->query("SELECT * FROM utilisateurs WHERE id = $id");
           return $result->fetch_assoc();
        }
        else {
            return null;
        }
    }
    public function connect($login, $password){
        global $conn;
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $this->sid = $data['id'];
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
    public function disconnect(){
        $this->sid = null;
        $this->login = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
    }
    public function delete(){
    $sql ="DELETE FROM utilisateurs WHERE id = $this->sid";
        global $conn;
        if($conn->query($sql)){
            $this->disconnect();
            return true;
        }
        else {
            return false;
        }
    }
    public function update($login, $password,$email, $firstname,$lastname){
        $sql = "UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = $this->sid";
        global $conn;
        if($conn->query($sql)){
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->password = $password;
            return true;
        }
        else {
            return false;
        }
    }
    public function isconnected(){
        return $this->sid !== null;
    }
    public function getAllInfos(){
       global $conn;
       $sql = "SELECT * FROM utilisateurs WHERE id = $this->sid";
       $result = $conn->query($sql);
       if($result->num_rows > 0){
           $data = $result->fetch_assoc();
           echo $data["logiqn"]."<br>";
           echo $data["email"]."<br>";
           echo $data["firstname"]."<br>";
           echo $data["lastname"]."<br>";
       }
       else {
           echo "No user found.";
       }
   }
   public function getlogin(){
         return $this->login;
   }
   public function getemail(){
    return $this ->email;
   }
   public function getFirstname(){
    return $this->firstname;
   }
   public function getLastname(){
    return $this-> lastname ;
   }
}


?>