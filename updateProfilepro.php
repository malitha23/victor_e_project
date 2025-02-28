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
     public function validateDate($date) {
          $format = 'Y-m-d';
          $d = DateTime::createFromFormat($format, $date);
          // The date is valid if $d is a valid DateTime object and the formatted output matches the input date
          return $d && $d->format($format) === $date;
      }
      
      public function validateMobile($mobile) {
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
               if (!empty($userdata["address2"])) {
                    if (($userdata["city"]) == 0) {
                         return "select your city";
                    } elseif ($userdata["city"] == 0) {
                         return "select your district";
                    } else {
                         //
                         $u = Database::Search("SELECT * FROM  `user` WHERE `email`='" . $userdata["email"] . "' ");
                         $u_num = $u->num_rows;

                         if ($u_num == 0) {
                              return "something else";
                         } else {
                              $u_data = $u->fetch_assoc();
                              if (empty($u_data["adress_id"])) {
                                   $dc = Database::Search("SELECT * FROM `city_has_distric` WHERE `city_city_id`='" . $userdata["city"] . "' ");
                                   $dcdata = $dc->fetch_assoc();
                                   if ($dcdata["distric_distric_id"] == $userdata["district"]) {
                                        $dcc = Database::Search("SELECT * FROM `city_has_distric` WHERE `city_city_id`='" . $userdata["city"] . "'");
                                        $dccc = $dcc->fetch_assoc();
                                        if ($dccc["distric_distric_id"] == $userdata["district"]) {
                                             $address1 = $userdata["address1"];
                                             $address2 = $userdata["address2"];
                                             $city = $userdata["city"];
                                             $district = $userdata["district"];

                                             $insertQuery = "INSERT INTO `address` (`line_1`, `line_2`, `city_city_id`, `distric_distric_id`) VALUES (?, ?, ?, ?);";
                                             $params = [$address1, $address2, $city, $district];
                                             $types = "ssii";
                                             $result = Database::IUD($insertQuery, $params, $types);
                                             if ($result) {
                                                  $address_id = Database::$connection->insert_id;
                                                  if ($address_id) {
                                                       $this->mainuserin($userdata, $address_id);
                                                  } else {
                                                       return "Error: Unable to retrieve the last inserted address ID.";
                                                  }
                                             } else {
                                                  return "Error: Unable to execute the insert query.";
                                             }
                                        } else {
                                             return "district and city not match.";
                                        }
                                   } else {
                                        return "district and city not match.";
                                   }
                              } else {
                                   $u = Database::Search("SELECT * FROM  `user` WHERE `email`='" . $userdata["email"] . "' ");
                                   $u_num = $u->num_rows;
                                   $x = $u->fetch_assoc();
                                   $adressid = $x["adress_id"];
                                   $dc = Database::Search("SELECT * FROM `city_has_distric` WHERE `city_city_id`='" . $userdata["city"] . "' ");
                                   $cdnum = $dc->num_rows;
                                   if ($cdnum == 1) {
                                        $dcdata = $dc->fetch_assoc();
                                        if ($dcdata["distric_distric_id"] == $userdata["district"]) {
                                             $dcc = Database::Search("SELECT * FROM `city_has_distric` WHERE `city_city_id`='" . $userdata["city"] . "'");
                                             $dccc = $dcc->fetch_assoc();
                                             if ($dccc["distric_distric_id"] == $userdata["district"]) {
                                                  $adressid = $x["adress_id"];
                                                  $address1 = $userdata["address1"];
                                                  $address2 = $userdata["address2"];
                                                  $city = $userdata["city"];
                                                  $district = $userdata["district"];
                                                  Database::IUD("UPDATE `address` SET `line_1` = '" . $address1 . "', `line_2` = '" . $address2 . "', `city_city_id` = '" . $city . "', `distric_distric_id` = '" . $district . "' 
                                                  WHERE (`address_id` = '" . $adressid . "');");
                                                  $lastInsertIdQuery = 0;
                                                  return  $this->mainuserin($userdata, $lastInsertIdQuery);
                                             } else {
                                                  return "district and city not match.";
                                             }
                                        } else {
                                             return "district and city not match.";
                                        }
                                   } else {
                                        return "pleace select distric and city";
                                   }
                              }
                         }
                    }
               } else {
                    $lastInsertIdQuery = 0;
                    return $this->mainuserin($userdata, $lastInsertIdQuery);
               }
          }
     }
     public function mainuserin($userdata, $lastInsertIdQuery)
     {
          if ($lastInsertIdQuery == 0) {
               Database::IUD("UPDATE `victore`.`user`
               SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "', `bod` = '" . $userdata["birthday"] . "' WHERE
                (`email` = '" . $userdata["email"] . "');");
               return "profile update";
          } else {
               Database::IUD("UPDATE `victore`.`user`
               SET `fname`='" . $userdata["fname"] . "',`lname`='" . $userdata["lname"] . "',`mobile` = '" . $userdata["mobile"] . "', `bod` = '" . $userdata["birthday"] . "', `adress_id` = '" . $lastInsertIdQuery . "' WHERE
                (`email` = '" . $userdata["email"] . "');");
               return "profile update";
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
