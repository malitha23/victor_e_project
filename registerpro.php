<?php
require "connection.php";
require "sequrity.php";

class Main
{
     public $mobile;
     public $email;
     public $password;

     public function validatePassword($password)
     {
          return preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password);
     }

     public function validateMobile($mobile)
     {
          return preg_match('/^[0-9]{10}$/', $mobile);
     }

     public function main()
     {
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
               $this->mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
               $this->email = isset($_POST['email']) ? trim($_POST['email']) : '';
               $this->password = isset($_POST['password']) ? trim($_POST['password']) : '';
          }else{
               $this->email = "";
               $this->mobile = "";
               $this->password = "";
          }
         
          // Validation for fields
          if (empty($this->email)) {
               return "Please enter your email";
          } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
               return "Invalid email format";
          } elseif (strlen($this->email) > 101) {
               return "Email is too long";
          } elseif (empty($this->mobile)) {
               return "Please enter your mobile number";
          } elseif (!$this->validateMobile($this->mobile)) {
               return "Invalid mobile number format. It should be 10 digits.";
          } elseif (empty($this->password)) {
               return "Password is empty";
          } elseif (strlen($this->password) > 16) {
               return "Password is too long";
          } elseif (!$this->validatePassword($this->password)) {
               return "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
          } else {
               $user_data = [
                    'email' => $this->email,
                    'mobile' => $this->mobile,
                    'password' => $this->password,
               ];
               $x = new Validate();
               return $x->get($user_data);
          }
     }
}

class Validate
{
     public function get($user_data)
     {
          // Sanitize and validate input data
          foreach ($user_data as $key => $value) {
               if (!Security::sanitizeInput($value)) {
                    return "Potential SQL injection detected in field: $key";
               }
          }

          $g = new DataInsert();
          return $g->dataInsert($user_data);
     }
}

class DataInsert
{
     public function userCheck($email)
     {
          $query = "SELECT * FROM `user` WHERE `email` = '" . $email . "'";
          $result = Database::search($query);
          return $result->num_rows > 0;
     }

     public function dataInsert($user_data)
     {
          if (!$this->userCheck($user_data["email"])) {
               $d = new DateTime();
               $tz = new DateTimeZone("Asia/Colombo");
               $d->setTimezone($tz);
               $date = $d->format("Y-m-d H:i:s");
               $mailToken = bin2hex(random_bytes(4));

               Database::IUD("INSERT INTO `user` (`email`, `mail`, `mobile`, `password`, `date`) 
            VALUES ('" . $user_data["email"] . "', '" . $mailToken . "','" . $user_data["mobile"] . "','" . $user_data["password"] . "','" . $date . "')");
               return "User inserted successfully.";
          } else {
               return "This email is already registered.";
          }
     }
}

// Instantiate the Main class and execute the registration process
$x = new Main();
$response = $x->main();
echo $response;
