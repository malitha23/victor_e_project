function addnewgroup() {
     var name = document.getElementById("ngname").value;
     if (!name) {
          alert("Group name cannot be empty!");
          return;
     }
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("name", name);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    alert(req.responseText);
               } else {
                    alert("Error adding group!");
               }
          }
     };
     req.open("POST", "addgroup.php", true);
     req.send(form);
}
function adnewCategory() {
     var newCategory = document.getElementById("newCategory").value.trim();
     var groupid = document.getElementById("groupid").value;
     if (!newCategory) {
          alert("Category name cannot be empty!");
          return;
     }
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("category", newCategory);
     form.append("groupid", groupid);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    alert(req.responseText);
               } else {
                    alert("Error adding category!");
               }
          }
     };

     req.open("POST", "addcategory.php", true);
     req.send(form);
}
function adnewSubCategory() {
     var subcate = document.getElementById("newsubCategory").value;
     var cateid = document.getElementById("nscpid").value;
     var req = new XMLHttpRequest();
     var formData = new FormData();
     formData.append("subCategory", subcate);
     formData.append("categoryId", cateid);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    alert(req.responseText);
               } else {
                    alert("Error adding category!");
               }
          }
     };
     req.open("POST", "addsubcategory.php", true);
     req.send(formData);
}

function productADD() {
     let title = document.getElementById("title").value;
     let productGroup = document.getElementById("Product_Group").value;
     let category = document.getElementById("product_category").value;
     let condition = document.getElementById("Condition").value;
     let status = document.getElementById("Status").value;
     let weight = document.getElementById("Weight").value;
     var description = tinymce.get("desc").getContent();
     let consignmentStock = document.getElementById("flexCheckChecked").checked ? 1 : 0;
     let product_subcategory = document.getElementById("product_subcategory").value;
     let brand = document.getElementById("brand").value;
     // Image inputs
     let img1 = document.getElementById("img_input_1").files[0];
     let img2 = document.getElementById("img_input_2").files[0];
     let img3 = document.getElementById("img_input_3").files[0];

     // Validate input fields
     if (!title || productGroup == "0" || category == "0" || condition == "0" || status == "0" || !weight) {
          Swal.fire({
               title: "Response",
               text: "Please fill all required fields.",
               icon: "warning",
               showConfirmButton: false,
               timer: 3000,
               toast: true,
               position: "top-end"
          });
          return;
     }

     let formData = new FormData();
     formData.append("title", title);
     formData.append("productGroup", productGroup);
     formData.append("category", category);
     formData.append("condition", condition);
     formData.append("status", status);
     formData.append("weight", weight);
     formData.append("description", description);
     formData.append("consignmentStock", consignmentStock);
     formData.append("product_subcategory", product_subcategory);
     formData.append("brand", brand);

     if (img1) formData.append("img1", img1);
     if (img2) formData.append("img2", img2);
     if (img3) formData.append("img3", img3);

     let xhr = new XMLHttpRequest();
     xhr.open("POST", "product_add_pro.php", true);
     xhr.onload = function () {
          if (this.status == 200) {
               if (this.responseText == 1) {
                    Swal.fire({
                         title: "Response",
                         text: "success,file not uploaded",
                         icon: "success",
                         showConfirmButton: false,
                         timer: 3000,
                         toast: true,
                         position: "top-end"
                    });
               } else if (this.responseText == 2) {
                    Swal.fire({
                         title: "Response",
                         text: "success,file uploaded",
                         icon: "success",
                         showConfirmButton: false,
                         timer: 3000,
                         toast: true,
                         position: "top-end"
                    });
               } else {
                    Swal.fire({
                         title: "Response",
                         text: this.responseText,
                         icon: "warning",
                         showConfirmButton: false,
                         timer: 3000,
                         toast: true,
                         position: "top-end"
                    });
               }
          }
     };
     xhr.send(formData);
}
function addnewbrand() {
     var name = document.getElementById("newbrand").value;
     var form = new FormData();
     form.append("name", name);
     let xhr = new XMLHttpRequest();
     xhr.open("POST", "addbrand.php", true);
     xhr.onload = function () {
          if (this.status == 200) {
               alert(this.responseText);
          }
     };
     xhr.send(form);
}
function batchADD() {
     // Get form values
     var productID = document.getElementById("bpro").value;
     var vendor = document.getElementById("vendor").value.trim();
     var batchQty = document.getElementById("batchqty").value.trim();
     var batchPrice = document.getElementById("batchprice").value.trim();
     var sellingPrice = document.getElementById("SellingPrice").value.trim();
     var batchcode = document.getElementById("batchcode").value;
     // Validate inputs
     if (productID == "0") {
          Swal.fire("Warning!", "Please select a product.", "warning");
          return;
     }
     if (vendor === "") {
          Swal.fire("Warning!", "Vendor Name is required.", "warning");
          return;
     }
     if (batchQty === "" || isNaN(batchQty) || batchQty <= 0) {
          Swal.fire("Warning!", "Enter a valid batch quantity.", "warning");
          return;
     }
     if (batchPrice === "" || isNaN(batchPrice) || batchPrice <= 0) {
          Swal.fire("Warning!", "Enter a valid batch price.", "warning");
          return;
     }
     if (sellingPrice === "" || isNaN(sellingPrice) || sellingPrice <= 0) {
          Swal.fire("Warning!", "Enter a valid selling price.", "warning");
          return;
     }

     // Prepare data to send
     var formData = new FormData();
     formData.append("productID", productID);
     formData.append("vendor", vendor);
     formData.append("batchQty", batchQty);
     formData.append("batchPrice", batchPrice);
     formData.append("sellingPrice", sellingPrice);
     formData.append("batchcode", batchcode);

     // AJAX request
     let xhr = new XMLHttpRequest();
     xhr.open("POST", "add_batch.php", true);
     xhr.onload = function () {
          if (this.status == 200) {
               Swal.fire({
                    title: "Success!",
                    text: this.responseText,
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
               });
               //  document.getElementById("vendor").value = "";
               //  document.getElementById("batchqty").value = "";
               //  document.getElementById("batchprice").value = "";
               //  document.getElementById("SellingPrice").value = "";
               //  document.querySelector(".form-select").value = "0";
          } else {
               Swal.fire("Error!", "Something went wrong.", "error");
          }
     };
     xhr.send(formData);
}
function update_product(product_id, batch_id) {
     // Get the values from the form fields
     var product_title = document.getElementById("productt" + batch_id).value;
     var product_category = document.getElementById("pc" + batch_id).value;
     var product_group = document.getElementById("group" + batch_id).value;
     var product_subcategory = document.getElementById("subcategory" + batch_id).value;
     var product_condition = document.getElementById("condition" + batch_id).value;
     var product_status = document.getElementById("status" + batch_id).value;
     var product_weight = document.getElementById("weight" + batch_id).value;
     var product_description = getDescription(batch_id);
     var brand = document.getElementById("brand" + batch_id).value;

     let img1 = document.getElementById("img_input_" + batch_id + "_" + "1").files[0] || 0;
     let img2 = document.getElementById("img_input_" + batch_id + "_" + "2").files[0] || 0;
     let img3 = document.getElementById("img_input_" + batch_id + "_" + "3").files[0] || 0;

     var formData = new FormData();
     formData.append("id", product_id);
     formData.append("title", product_title);
     formData.append("category", product_category);
     formData.append("group", product_group);
     formData.append("subcategory", product_subcategory);
     formData.append("condition", product_condition);
     formData.append("status", product_status);
     formData.append("weight", product_weight);
     formData.append("description", product_description);
     formData.append("brand", brand);

     if (img1) formData.append("img1", img1);
     if (img2) formData.append("img2", img2);
     if (img3) formData.append("img3", img3);

     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
               var res = this.responseText;

               switch (res) {
                    case "123":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "All images (1, 2, and 3) were successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "12":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Images 1 and 2 were successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "13":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Images 1 and 3 were successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "23":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Images 2 and 3 were successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "1":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Image 1 was successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "2":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Image 2 was successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "3":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "Image 3 was successfully uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    case "0":
                         Swal.fire({
                              icon: "success",
                              title: "Product Updated",
                              text: "No new files were uploaded.",
                              confirmButtonColor: "#3085d6"
                         });
                         break;
                    default:
                         Swal.fire({
                              icon: "error",
                              title: "Error",
                              text: res,
                              confirmButtonColor: "#d33"
                         });
                         break;
               }
          }
     };
     xhttp.open("POST", "update_product.php", true);
     xhttp.send(formData);
}

function getDescription(batch_id) {
     var description = tinymce.get('desc' + batch_id).getContent();
     console.log(description);
     return description;
}
function savebatchup(batch_id) {

     var batchcode = document.getElementById("bbatch_code" + batch_id).value;
     var vendor = document.getElementById("vendornameb" + batch_id).value;
     var batchqty = document.getElementById("batchqty" + batch_id).value;
     var sellprice = document.getElementById("selling_price" + batch_id).value;
     var batchprice = document.getElementById("Batchprice" + batch_id).value;

     if (batchcode === "" || vendor === "" || batchqty === "" || sellprice === "" || batchprice === "") {
          Swal.fire({
               icon: 'error',
               title: 'Oops...',
               text: 'Please fill in all the required fields!',
               showClass: {
                    popup: 'animate__animated animate__shakeX'
               },
               hideClass: {
                    popup: 'animate__animated animate__fadeOut'
               }
          });
          return;
     }

     var req = new XMLHttpRequest();
     var form = new FormData();

     form.append("batch_id", batch_id);
     form.append("batchcode", batchcode);
     form.append("vendor", vendor);
     form.append("batchqty", batchqty);
     form.append("sellprice", sellprice);
     form.append("batchprice", batchprice);

     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    if (req.responseText.trim() === "success") {
                         Swal.fire({
                              icon: 'success',
                              title: 'Saved!',
                              text: 'Batch data saved successfully!',
                              showClass: {
                                   popup: 'animate__animated animate__zoomIn'
                              },
                              hideClass: {
                                   popup: 'animate__animated animate__fadeOut'
                              }
                         }).then(() => {
                              var modal = document.getElementById(`exampleModalb${batch_id}`);
                              var bootstrapModal = bootstrap.Modal.getInstance(modal);
                              bootstrapModal.hide();
                         });
                    } else {
                         Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'Error saving data: ' + req.responseText,
                              showClass: {
                                   popup: 'animate__animated animate__shakeX'
                              },
                              hideClass: {
                                   popup: 'animate__animated animate__fadeOut'
                              }
                         });
                    }
               } else {
                    Swal.fire({
                         icon: 'error',
                         title: 'Server Error!',
                         text: 'An error occurred while saving the data.',
                         showClass: {
                              popup: 'animate__animated animate__shakeX'
                         },
                         hideClass: {
                              popup: 'animate__animated animate__fadeOut'
                         }
                    });
               }
          }
     };
     req.open("POST", "savebatchup.php", true);
     req.send(form);
}
function confirmBlock(email) {
     Swal.fire({
          title: 'Are you sure?',
          text: "Do you really want to block this person?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, Block',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               sendBlockRequest(email);
          }
     });
}

function sendBlockRequest(email) {
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("email", email);

     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    if (req.responseText == 1) {
                         Swal.fire('UN-Blocked!', 'success');
                         location.reload();
                    } else if (req.responseText == 0) {
                         Swal.fire('Blocked!', 'success');
                         location.reload();
                    } else {
                         Swal.fire('user!', 'error');
                         location.reload();
                    }
               } else {
                    Swal.fire('Error!', 'Failed to block the user.', 'error');
               }
          }
     };

     req.open("POST", "usermanagepro.php", true); // Sends request to the same file
     req.send(form);
}
function callPHPFunction(email) {
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("email", email);

     req.onreadystatechange = function () {
          if (req.readyState == 4 && req.status == 200) {
               document.getElementById("userDetailsModal").innerHTML = req.responseText;
               const modal = new bootstrap.Modal(document.getElementById("detailsModal_1"));
               modal.show();
          }
     }
     req.open("POST", "user-details-mo.php", true);
     req.send(form);
}
function confirmUNBlock(email) {
     Swal.fire({
          title: 'Are you sure?',
          text: "Do you really want to UN-block this person?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, UN-Block',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               sendBlockRequest(email);
          }
     });
}
function SearchUser() {
     var ukey = document.getElementById("ukey").value.trim(); // Trim whitespace
     if (!ukey) {
          alert("Please enter a search key.");
          return;
     }
     var form = new FormData();
     form.append("key", ukey);
     var req = new XMLHttpRequest();
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    if (req.responseText == 0) {
                         alert("not found");
                    } else {
                         document.getElementById("userarea").innerHTML = req.responseText;
                    }
               } else {
                    alert("Error: Unable to fetch data. Please try again.");
               }
          }
     }
     req.open("POST", "searchuser.php", true);
     req.send(form);
}
function submitdiscount() {
     var title = document.getElementById("title").value;
     var desc = document.getElementById("description").value;
     var image = document.getElementById("image").files[0] || null;
     var batch = document.getElementById("batch").value;
     var qty = document.getElementById("qty").value;
     var discount = document.getElementById("discount").value;
     var start_date = document.getElementById("start_date").value;
     var end_date = document.getElementById("end_date").value;

     var formData = new FormData();
     formData.append("title", title);
     formData.append("description", desc);
     formData.append("image", image);
     formData.append("batch", batch);
     formData.append("qty", qty);
     formData.append("discount", discount);
     formData.append("start_date", start_date);
     formData.append("end_date", end_date);

     var xhr = new XMLHttpRequest();
     xhr.open("POST", "adddispro.php", true);

     xhr.onload = function () {
          if (xhr.status === 200) {
               if (xhr.responseText == "01") {
                    Swal.fire({
                         title: 'Response',
                         text: "Discount successfully added.",
                         icon: 'success',
                         confirmButtonText: 'OK'
                    });
               } else if (xhr.responseText == "11") {
                    Swal.fire({
                         title: 'Response',
                         text: "Discount successfully added,image uploaded..",
                         icon: 'success',
                         confirmButtonText: 'OK'
                    });
               } else if (xhr.responseText == "1") {
                    Swal.fire({
                         title: 'Response',
                         text: "Discount successfully added.",
                         icon: 'success',
                         confirmButtonText: 'OK'
                    });
               } else {
                    Swal.fire({
                         title: 'Response',
                         text: xhr.responseText,
                         icon: 'info',
                         confirmButtonText: 'OK'
                    });
               }
          } else {
               alert("Error: " + xhr.status);
          }
     };
     xhr.send(formData);
}
function updatedis(x) {
     var form = new FormData();
     form.append("groupid", x);

     var req = new XMLHttpRequest();
     req.open("POST", "update_discountm.php", true);

     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               document.getElementById("inject-model").innerHTML = req.responseText;
               const modal = new bootstrap.Modal(document.getElementById("exampleModal" + x));
               modal.show();
          }
     };
     req.send(form);
}

function saveUpdate(x) {
     var form = new FormData();
     form.append("groupid", x);
     form.append("title", document.getElementById("title" + x).value);
     form.append("description", document.getElementById("description" + x).value);
     form.append("discountPre", document.getElementById("discountPre" + x).value);
     form.append("qty", document.getElementById("qty" + x).value);
     form.append("start_date", document.getElementById("start_date" + x).value);
     form.append("end_date", document.getElementById("end_date" + x).value);
     form.append("image", document.getElementById("img_input_" + x).files[0]);

     var req = new XMLHttpRequest();
     req.open("POST", "update_discountpro.php", true);

     req.onreadystatechange = function () {
          if (req.readyState === 4 && req.status === 200) {
               Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Discount details updated successfully.'
               }).then(() => {
                    location.reload();
               });
          } else if (req.readyState === 4) {
               Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update discount details.'
               });
          }
     };
     req.send(form);
}

function savecities() {
     var distric = document.getElementById("ad_id").value;
     var count = document.getElementById("num").value;
     if (count > 0) {


          var cities = [];
          x = 0;
          y = 0;
          for (let index = 0; index < count; index++) {
               x = x + 1;
               var tcValue = document.getElementById("tc_" + x).value;
               cities[y] = tcValue;
               y = y + 1;
          }
          var length = cities.length;
          var req = new XMLHttpRequest();
          var form = new FormData;
          form.append("length", length);
          form.append("distric", distric);
          m = 1;
          z = 0;
          for (let index = 0; index < length; index++) {
               form.append("city" + m, cities[z]);
               m = m + 1;
               z = z + 1;
          }
          req.onreadystatechange = function () {
               if (req.readyState === 4 && req.status === 200) {
                    if (req.responseText == 1) {
                         Swal.fire({
                              title: 'City Added',
                              text: "City Added success",
                              icon: 'success',
                              showClass: {
                                   popup: 'animate__animated animate__fadeInDown'
                              },
                              hideClass: {
                                   popup: 'animate__animated animate__fadeOutUp'
                              }
                         });

                    } else {
                         Swal.fire({
                              title: 'City Added',
                              text: req.responseText,
                              icon: 'error',
                              showClass: {
                                   popup: 'animate__animated animate__fadeInDown'
                              },
                              hideClass: {
                                   popup: 'animate__animated animate__fadeOutUp'
                              }
                         });

                    }
               }
          }
          req.open("POST", "process/Savecity.php", true);
          req.send(form);
     } else {
          alert("type city name..press the add button");
     }
}
function update_dprice(){
     var tocity = document.getElementById("c_id2").value;
     var d_price = document.getElementById("d_price").value;
     
     var form = new FormData();
     form.append("tocity", tocity);
     form.append("d_price", d_price);
 
     var req = new XMLHttpRequest();
     req.open("POST", "process/addeliveryfee.php", true);
     
     req.onreadystatechange = function() {
         if (req.readyState === 4 && req.status === 200) {
             Swal.fire({
                 title: 'Delivery fee Added status',
                 text: req.responseText,
                 icon: 'success',
                 showClass: {
                     popup: 'animate__animated animate__fadeInDown'
                 },
                 hideClass: {
                     popup: 'animate__animated animate__fadeOutUp'
                 }
             });
         }
     };
     
     req.send(form);
 }
 
