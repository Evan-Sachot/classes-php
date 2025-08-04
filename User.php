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

}


?>