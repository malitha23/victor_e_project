<?php
session_start();

if (isset($_SESSION["a"])) {
     include "db.php";
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          if (isset($_POST['key'])) {
               $key = htmlspecialchars($_POST['key']);
               $u = Databases::Search("SELECT * FROM `user` WHERE `email`='" . $key . "' ");
               $unum = $u->num_rows;
               if ($unum == 1) {
?>
                    <div class="row" id="userarea">
                         <section>
                              <div class="gradient-custom-1 h-100">
                                   <div class="mask d-flex align-items-center h-100">
                                        <div class="container">
                                             <div class="row justify-content-center">
                                                  <div class="col-12">
                                                       <div class="table-responsive bg-white">
                                                            <table class="table mb-0">
                                                                 <thead>
                                                                      <tr>
                                                                           <th scope="col">#</th>
                                                                           <th scope="col">FULL NAME</th>
                                                                           <th scope="col">EMAIL</th>
                                                                           <th scope="col">DETAILS</th>
                                                                           <th scope="col">STATUS</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php
                                                                      $user = Databases::Search("SELECT * FROM `user`  WHERE `email`='" . $key . "' ");
                                                                      $usernum = $user->num_rows;
                                                                      for ($i = 0; $i < $usernum; $i++) {
                                                                           $userdata = $user->fetch_assoc();
                                                                      ?>
                                                                           <tr>
                                                                                <td><?php echo $i + 1; ?></td>
                                                                                <td><?php echo $userdata["fname"] . " " . $userdata["lname"]; ?></td>
                                                                                <td><?php echo $userdata["email"]; ?></td>
                                                                                <td>
                                                                                     <a class="tex-b log-link fw-bold" data-bs-toggle="modal" onclick="callPHPFunction('<?php echo $userdata["email"]; ?>')">SHOW</a>
                                                                                </td>
                                                                                <td>
                                                                                     <?php
                                                                                     if ($userdata["status"] == 0) {
                                                                                     ?>
                                                                                          <a class="btn ub-btn p-1" onclick="confirmUNBlock('<?php echo $userdata['email']; ?>')">UNBLOCK</a>
                                                                                     <?php
                                                                                     } else {
                                                                                     ?>
                                                                                          <a class="btn ub-btn p-1" onclick="confirmBlock('<?php echo $userdata['email']; ?>')">BLOCK</a>
                                                                                     <?php
                                                                                     }
                                                                                     ?>
                                                                                </td>
                                                                           </tr>
                                                                      <?php
                                                                      }
                                                                      ?>
                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </section>
                    </div>
<?php
               } else {
                    echo 0;
               }
          } else {
               http_response_code(400);
               echo "Invalid request. Search key is missing.";
          }
     }
}
