<?php
session_start();
require_once "sequrity.php";
class main {
    public $email;
    public $password;
    public $remember;

    public function __construct() {
        $this->email =   isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $this->password =    isset($_POST["password"]) ? trim($_POST["password"]) : null;
        $this->remember = $_POST["remember"];
    }
    public function main(){
       $x = $this->submain();
       if($x == "true"){
          $instance = new check($this->email, $this->password, $this->remember);
          return $instance->check();
       }else{
        return $x;
       }
    }

    public function submain() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($this->email)) {
                return "Please enter your email.";
            }
            if(strlen($this->email) > 101){
               return "email is too long";
            }
            if(strlen($this->password)>16){
               return "password is too long";
            }
            if (empty($this->password)) {
                return "Please enter your password.";
            }
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format.";
            }
            return "true";
        } else {
            return "Invalid request method.";
        }
    }
}
class check extends main {
    public function __construct($email, $password , $remember) {
        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
    }
    public function checksql(){
        $sanitized_input = Security::sanitizeInput($this->email);
        if ($sanitized_input === false) {
             return "Potential SQL injection detected!";
        }else{
            $sanitized_input = Security::sanitizeInput($this->password);
            if ($sanitized_input === false) {
                 return "Potential SQL injection detected!";
            }else{
                return 1;
            }
        }
    }
    public function check(): string {
        $m=$this->checksql();
        if($m == 1){
            require_once "connection.php";
            Database::setUpConnection();
            $stmt = Database::$connection->prepare(
                "SELECT * FROM `user` WHERE `email` = ? AND `password` = ?  AND `status` = ?"
            );
            if ($stmt) {
                $status = 1;
                $stmt->bind_param("ssi", $this->email, $this->password ,$status);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (($this->password == $user['password'])) {
                        $_SESSION["user_vec"] = array(
                            "email" => $this->email,
                            "login_time" => date("Y-m-d H:i:s"), 
                            "ip_address" => $_SERVER['REMOTE_ADDR'], 
                            "user_agent" => $_SERVER['HTTP_USER_AGENT'], 
                        );                    
                        return $user['fname'] . " login success!";

                        if ($this->remember == "true") {
                            setcookie("email", $this->email, time() + (60 * 60 * 24 * 365), '/', '', true, true); 
                            setcookie("password", $this->password, time() + (60 * 60 * 24 * 365), '/', '', true, true);
                        } else {  
                            setcookie("email", "", time() - 3600, '/', '', true, true);
                            setcookie("password", "", time() - 3600, '/', '', true, true);
                        }
                    }else{
                        return "session errore.";
                    }
                } else {
                    return "Invalid email or password.";
                }
                $stmt->close();
            } else {
                return "Error preparing statement: " . Database::$connection->error;
            }
        }else{
            return $m;
        }
    }


}
$instance = new main();
$result = $instance->main();
echo $result;
?>
