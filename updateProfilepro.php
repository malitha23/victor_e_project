<?php

require "sequrity.php";

abstract class Variable
{
     protected $fname;
     protected $lname;
     protected $mobile;
     protected $birthday;
     protected $district;
     protected $city;
     protected $address1;
     protected $address2;
     protected $email;
}

class Main extends Variable
{
     public function __construct()
     {
          $this->fname = $this->sanitizeInput(INPUT_POST, 'firstname');
          $this->lname = $this->sanitizeInput(INPUT_POST, 'lastname');
          $this->mobile = $this->sanitizeInput(INPUT_POST, 'mobile');
          $this->birthday = $this->sanitizeInput(INPUT_POST, 'birthday');
          $this->district = $this->sanitizeInput(INPUT_POST, 'district');
          $this->city = $this->sanitizeInput(INPUT_POST, 'city');
          $this->address1 = $this->sanitizeInput(INPUT_POST, 'address1');
          $this->address2 = $this->sanitizeInput(INPUT_POST, 'address2');
          $this->email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
     }

     private function sanitizeInput($type, $variable_name)
     {
          $value = filter_input($type, $variable_name, FILTER_UNSAFE_RAW);
          return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
     }
     public function validateDate($date)
     {
          $format = 'Y-m-d';
          $d = DateTime::createFromFormat($format, $date);
          // The date is valid if $d is a valid DateTime object and the formatted output matches the input date
          return $d && $d->format($format) === $date;
     }

     public function validateMobile($mobile)
     {
          // Allow optional leading '+' followed by 10 to 15 digits
          return preg_match('/^\+?[0-9]{10,15}$/', $mobile);
     }

     public function main()
     {
          if (!empty($this->birthday)) {
               if (!$this->validateDate($this->birthday)) {
                    return "Invalid date format. Please use YYYY-MM-DD.";
               }
          }

          if (!empty($this->mobile)) {
               if (!$this->validateMobile($this->mobile)) {
                    return "Invalid mobile number. Please enter a valid number with 10 to 15 digits.";
               }
          }

          $userdata = [
               'email'     => $this->email,
               'fname'     => $this->fname,
               'lname'     => $this->lname,
               'mobile'    => $this->mobile,
               'birthday'  => $this->birthday,
               'district'  => $this->district,
               'city'      => $this->city,
               'address1'  => $this->address1,
               'address2'  => $this->address2
          ];

          $checker = new Checkk();
          $result = $checker->validate($userdata);

          if ($result === true) {
               $sql = new sql;
               $usql = $sql->sql($userdata);
               return $usql;
          } else {

               return $result;
          }
     }
}
class sql
{
     public function sql($userdata)
     {
          require_once "connection.php";
          if (!empty($userdata["address1"])) {
               if (empty($userdata["address2"])) {
                    $dcv = $this->citydistricvalidation($userdata["city"], $userdata["district"]);
                    if ($dcv == 1) {
                         $adress = $this->addressceck($userdata["email"]);
                         if ($adress == 0) {
                              Database::IUD("INSERT INTO 
                         `victore`.`address` (`line_1`,`line_2`, `city_city_id`, `distric_distric_id`) 
                         VALUES ('" . $userdata["address1"] . "','', '" . $userdata["city"] . "', '" . $userdata["district"] . "')");
                              $lastInsertIdQuery = Database::$connection->insert_id;
                              return $this->mainuserin($userdata, $lastInsertIdQuery);
                         } else {
                              Database::IUD("UPDATE `address` 
                              SET `line_1` = '" . $userdata["address1"] . "',`line_2`='', `city_city_id` = '" . $userdata["city"] . "', `distric_distric_id` = '" . $userdata["district"] . "'
                               WHERE (`address_id` = '" . $adress . "');");
                               $lastInsertIdQuery = $adress;
                               return $this->mainuserin($userdata, $lastInsertIdQuery);
                         }
                    } else {
                         return "dristric and city is note match";
                    }
               } else {
                    $dcv = $this->citydistricvalidation($userdata["city"], $userdata["district"]);
                    if ($dcv == 1) {
                         $adress = $this->addressceck($userdata["email"]);
                         if ($adress == 0) {
                              Database::IUD("INSERT INTO 
                              `victore`.`address` (`line_1`,`line_2`, `city_city_id`, `distric_distric_id`) 
                              VALUES ('" . $userdata["address1"] . "','" . $userdata["address2"] . "', '" . $userdata["city"] . "', '" . $userdata["district"] . "')");
                              $lastInsertIdQuery = Database::$connection->insert_id;
                              return $this->mainuserin($userdata, $lastInsertIdQuery);
                         } else {
                              Database::IUD("UPDATE `address` 
                              SET `line_1` = '" . $userdata["address1"] . "', `line_2` = '" . $userdata["address2"] . "', `city_city_id` = '" . $userdata["city"] . "', `distric_distric_id` = '" . $userdata["district"] . "'
                               WHERE (`address_id` = '" . $adress . "');");
                               $lastInsertIdQuery = $adress;
                               return $this->mainuserin($userdata, $lastInsertIdQuery);
                         }
                    } else {
                         return "dristric and city is note match";
                    }
               }
          } else {
               if (!empty($userdata["address2"])) {
                    return  "pleace enter address line one first";
               } else {
                    $lastInsertIdQuery = 0;
                    return $this->mainuserin($userdata, $lastInsertIdQuery);
               }
          }
     }
     public function addressceck($email)
     {
          $d = Database::Search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
          $data = $d->fetch_assoc();
          if (empty($data["adress_id"])) {
               return 0;
          } else {
               return $data["adress_id"];
          }
     }
     public function citydistricvalidation($city, $district)
     {
          $dc = Database::Search("SELECT * FROM `city_has_distric` WHERE `city_city_id`='" . $city . "' AND `distric_distric_id`='" . $district . "' ");
          $dcnum = $dc->num_rows;
          if ($dcnum == 1) {
               return 1;
          }
     }
     public function mainuserin($userdata, $lastInsertIdQuery)
     {
          if ($lastInsertIdQuery == 0) {
               if (empty($userdata["birthday"])) {
                    Database::IUD("UPDATE `user`
                    SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "' WHERE
                     (`email` = '" . $userdata["email"] . "');");
                    return "profile update";
               } else {
                    Database::IUD("UPDATE `user`
                    SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "', `bod` = '" . $userdata["birthday"] . "' WHERE
                     (`email` = '" . $userdata["email"] . "');");
                    return "profile update";
               }
          } else {
               if (empty($userdata["birthday"])) {
                    Database::IUD("UPDATE `user`
                    SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "', `adress_id` = '" . $lastInsertIdQuery . "' WHERE
                     (`email` = '" . $userdata["email"] . "');");
                    return "profile update";
               } else {
                    Database::IUD("UPDATE `user`
                    SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "', `bod` = '" . $userdata["birthday"] . "', `adress_id` = '" . $lastInsertIdQuery . "' WHERE
                     (`email` = '" . $userdata["email"] . "');");
                    return "profile update";
               }
          }
     }
}
class Checkk
{
     public function validate($userdata)
     {
          foreach ($userdata as $key => $value) {
               $sanitized_value = Security::sanitizeInput($value);
               if ($sanitized_value === false) {
                    return "Potential SQL injection detected in field '$key'.";
               }
          }
          return true;
     }
}

$x = new Main();
$xx = $x->main();
echo $xx;
