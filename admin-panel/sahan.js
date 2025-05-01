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

     // Show a waiting alert before sending the request
     Swal.fire({
          title: 'Please wait...',
          text: 'Processing your request...',
          allowOutsideClick: false,
          didOpen: () => {
               Swal.showLoading();
          }
     });

     xhr.open("POST", "product_add_pro.php", true);
     xhr.onload = function () {
          Swal.close(); // Close the loading alert when the request completes

          if (this.status == 200) {
               let toastConfig = {
                    title: "Response",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: "top-end"
               };

               if (this.responseText == 1) {
                    toastConfig.text = "Success, file not uploaded";
               } else if (this.responseText == 2) {
                    toastConfig.text = "Success, file uploaded";
               } else {
                    toastConfig.text = this.responseText;
                    toastConfig.icon = "warning"; // Change icon for warnings
               }

               Swal.fire(toastConfig).then(() => {
                    location.reload(); // Reload the page after the alert
               });
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

     // Show a waiting alert before sending the request
     Swal.fire({
          title: 'Please wait...',
          text: 'Processing your request...',
          allowOutsideClick: false,
          didOpen: () => {
               Swal.showLoading();
          }
     });

     xhr.open("POST", "add_batch.php", true);
     xhr.onload = function () {
          Swal.close(); // Close the loading alert when the request completes

          if (this.status == 200) {
               Swal.fire({
                    title: "Success!",
                    text: this.responseText,
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
               }).then(() => {
                    location.reload(); // Reload the page after the success message
               });

               // Clear form fields
               document.getElementById("vendor").value = "";
               document.getElementById("batchqty").value = "";
               document.getElementById("batchprice").value = "";
               document.getElementById("SellingPrice").value = "";
               document.getElementById("batchcode").value = ""; // Fixed querySelector mistake
          } else {
               Swal.fire("Error!", "Something went wrong.", "error");
          }
     };

     xhr.send(formData);

}
function update_product(product_id) {
     // Get the values from the form fields
     var product_title = document.getElementById("productt" + product_id).value;
     var product_category = document.getElementById("pc" + product_id).value;
     var product_group = document.getElementById("group" + product_id).value;
     var product_subcategory = document.getElementById("subcategory" + product_id).value;
     var product_condition = document.getElementById("condition" + product_id).value;
     var product_status = document.getElementById("status" + product_id).value;
     var product_weight = document.getElementById("weight" + product_id).value;
     var product_description = getDescription(product_id);
     var brand = document.getElementById("brand" + product_id).value;

     let img1 = document.getElementById("img_input_" + product_id + "_" + "1").files[0] || 0;
     let img2 = document.getElementById("img_input_" + product_id + "_" + "2").files[0] || 0;
     let img3 = document.getElementById("img_input_" + product_id + "_" + "3").files[0] || 0;

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
               alert(res);
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

function getDescription(product_id) {
     var description = tinymce.get('desc' + product_id).getContent();
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
     var inputs = document.querySelectorAll("#town_col input");
     var cities = [];

     // Check for empty fields
     for (let input of inputs) {
          let val = input.value.trim();
          if (val === "") {
               alert("Please fill out all city name fields before saving.");
               return; // Stop the function
          }
          cities.push(val);
     }

     if (cities.length === 0) {
          alert("Please add at least one city before saving.");
          return;
     }

     var form = new FormData();
     form.append("distric", distric);
     form.append("length", cities.length);

     cities.forEach((city, index) => {
          form.append("city" + (index + 1), city);
     });

     // Send AJAX request
     var req = new XMLHttpRequest();
     Swal.fire({
          title: 'Please wait...',
          text: 'Adding city...',
          allowOutsideClick: false,
          didOpen: () => {
               Swal.showLoading();
          }
     });

     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               Swal.close();
               if (req.status === 200) {
                    if (req.responseText == "1") {
                         Swal.fire({
                              title: 'Success!',
                              text: 'City added successfully!',
                              icon: 'success'
                         }).then(() => {
                              location.reload();
                         });
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: req.responseText,
                              icon: 'error'
                         });
                    }
               } else {
                    Swal.fire({
                         title: 'Error!',
                         text: 'Something went wrong. Please try again.',
                         icon: 'error'
                    });
               }
          }
     };

     req.open("POST", "process/Savecity.php", true);
     req.send(form);
}

function update_dprice() {
     var table = document.getElementById("df-table");
     var rows = table.getElementsByTagName("tr");
     var formData = new FormData();
     var hasChanges = false;

     if (rows.length == 0) {
          Swal.fire({
               title: 'No Cities in the List',
               text: 'Please add cities or select a district first.',
               icon: 'error'
          });
          return;
     }

     for (var i = 0; i < rows.length; i++) {
          var input = rows[i].getElementsByTagName("input")[0];
          var id = input.id;
          var value = input.value.trim();
          var original = input.getAttribute("data-original").trim();

          // Only add to FormData if the value has changed
          if (value !== original) {
               if (value === "") {
                    Swal.fire({
                         title: 'Some Fees are Empty.',
                         text: 'Please fill in all input fields.',
                         icon: 'error'
                    });
                    return;
               }

               formData.append(id, value);
               hasChanges = true;
          }
     }

     if (!hasChanges) {
          Swal.fire({
               title: 'No Changes Detected',
               text: 'You have not made any changes.',
               icon: 'info'
          });
          return;
     }

     var xhr = new XMLHttpRequest();
     xhr.open("POST", "process/change-d-fee.php", true);

     Swal.fire({
          title: 'Please wait...',
          text: 'Saving data...',
          allowOutsideClick: false,
          didOpen: () => {
               Swal.showLoading();
          }
     });

     xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
               Swal.close();

               if (xhr.status === 200) {
                    if (xhr.responseText == "1") {
                         Swal.fire({
                              title: 'Success!',
                              text: 'City fees updated successfully!',
                              icon: 'success'
                         }).then(() => {
                              location.reload();
                         });
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: xhr.responseText,
                              icon: 'error'
                         });
                    }
               } else {
                    Swal.fire({
                         title: 'Error',
                         text: 'Something went wrong. Please try again.',
                         icon: 'error'
                    });
               }
          }
     };

     xhr.send(formData);
}


function change_emailN() {
     var email = document.getElementById("contact_email").value;
     var mobile = document.getElementById("contact_mobile").value;

     var form = new FormData();
     form.append("email", email);
     form.append("mobile", mobile);

     var req = new XMLHttpRequest();
     req.open("POST", "process/change_emailN.php", true);

     req.onreadystatechange = function () {
          if (req.readyState === 4 && req.status === 200) {
               Swal.fire({
                    title: 'Contact Information Updated',
                    text: req.responseText,
                    icon: 'success',
                    showClass: {
                         popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                         popup: 'animate__animated animate__fadeOutUp'
                    }
               });
               location.reload();
          }
     };

     req.send(form);
}
function OrderStatusSave(x) {
     var status = document.getElementById("statusChangeProduct1" + x).value;

     var form = new FormData();
     form.append("status", status);
     form.append("orderId", x);

     var req = new XMLHttpRequest();
     req.open("POST", "process/OrderStatusSave.php", true);

     req.onreadystatechange = function () {
          if (req.readyState === 4 && req.status === 200) {
               Swal.fire({
                    title: 'Order Status Updated',
                    text: req.responseText,
                    icon: 'success',
                    showClass: {
                         popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                         popup: 'animate__animated animate__fadeOutUp'
                    }
               });
               location.reload();
          }
     };

     req.send(form);
}
function handleCheckbox(checkbox) {
     const id = checkbox.getAttribute('data-id');
     const state = checkbox.checked ? 'true' : 'false';

     console.log('Checkbox ID:', id);
     console.log('Checkbox State:', state);
}
function submitdisdetails(x) {
     const title = document.getElementById('titleInput').value;
     const description = tinymce.get('descriptionInput').getContent();
     var start_date = document.getElementById("start_date").value;
     var end_date = document.getElementById("end_date").value;
     var Discount = document.getElementById("Discount").value;
     var img = document.getElementById("imageUpload").files[0];
     if (!img) {
          alert("Please select an image file.");
          return;
     }
     var batches = [];
     var y = 0;
     for (let index = 0; index < x; index++) {
          const status = document.getElementById("dcheck" + index).checked;
          if (status == true) {
               const id = document.getElementById("dcheck" + index).getAttribute('data-id');
               const qty = document.getElementById("qtyInput").value;
               batches[y] = [id, qty];
               y = y + 1;
          }
     }
     var length = batches.length;
     if (length == 0) {
          alert("Please select an batches.");
          return;
     }
     var form = new FormData;
     form.append("image", img);
     form.append("length", length);
     form.append("title", title);
     form.append("desc", description);
     form.append("start_date", start_date);
     form.append("end_date", end_date);
     form.append("Discount", Discount);
     for (let index = 0; index < length; index++) {
          form.append("batch" + index, batches[index][0]);
          form.append("qty" + index, batches[index][1]);
     }
     var req = new XMLHttpRequest();

     // Show a loading alert before sending the request
     Swal.fire({
          title: 'Please wait...',
          text: 'Saving discount details...',
          allowOutsideClick: false,
          didOpen: () => {
               Swal.showLoading();
          }
     });

     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               Swal.close(); // Close the loading alert when request is complete

               if (req.status === 200) {
                    if (req.responseText == 1) {
                         Swal.fire({
                              icon: 'success',
                              title: 'Success!',
                              text: 'Discount added successfully! Image uploaded successfully!',
                              timer: 2000, // Show alert for 2 seconds
                              showConfirmButton: false
                         }).then(() => {
                              location.reload();
                         });
                    } else {
                         Swal.fire({
                              icon: 'info',
                              title: 'information!',
                              text: req.responseText
                         });
                    }
               } else {
                    Swal.fire({
                         icon: 'error',
                         title: 'Error!',
                         text: 'Failed to save the discount. Please try again.'
                    });
               }
          }
     };
     // Send the request with the form data
     req.open("POST", "process/savediscount.php", true);
     req.send(form);

}
function ADdiscount(x) {
     const modal = new bootstrap.Modal(document.getElementById('customModal'));
     modal.show();
     submitdiscount(x);
}
function updateQuantity(batchId, discountGroupId) {
     let qtyInput = document.getElementById("qtyInput" + batchId);
     let qty = qtyInput.value.trim();

     if (qty === "" || qty < 1) {
          Swal.fire({
               icon: "error",
               title: "Invalid Quantity",
               text: "Quantity must be at least 1.",
               confirmButtonColor: "#d33",
          });
          return;
     }

     let xhr = new XMLHttpRequest();
     xhr.open("POST", "process/updateQuantity.php", true);
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

     xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
               if (xhr.status === 200) {
                    alert(xhr.responseText);
                    Swal.fire({
                         icon: "success",
                         title: "Updated Successfully",
                         text: xhr.responseText,
                         confirmButtonColor: "#3085d6",
                    }).then(() => {
                         location.reload(); // Reload the page after confirmation
                    });
               } else {
                    Swal.fire({
                         icon: "error",
                         title: "Update Failed",
                         text: "Something went wrong. Please try again.",
                         confirmButtonColor: "#d33",
                    });
               }
          }
     };

     // Send batch ID, discount group ID, and quantity as parameters
     xhr.send("batchId=" + batchId + "&discountGroupId=" + discountGroupId + "&qty=" + qty);
}
function Removebatch(batchId, discountGroupId) {
     Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, remove it!"
     }).then((result) => {
          if (result.isConfirmed) {
               let xhr = new XMLHttpRequest();
               xhr.open("POST", "process/removeBatch.php", true);
               xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

               xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                         if (xhr.status === 200) {
                              Swal.fire({
                                   title: "Deleted!",
                                   text: "The batch has been removed.",
                                   icon: "success",
                                   confirmButtonColor: "#3085d6"
                              }).then(() => {
                                   location.reload(); // Refresh page after success
                              });
                         } else {
                              Swal.fire({
                                   title: "Error!",
                                   text: "Something went wrong. Please try again.",
                                   icon: "error",
                                   confirmButtonColor: "#d33"
                              });
                         }
                    }
               };
               xhr.send("batchId=" + batchId + "&discountGroupId=" + discountGroupId);
          }
     });
}
function updatedis(discountGroupId) {
     // Get the values from the modal's input fields
     var title = document.getElementById('distitle' + discountGroupId).value;
     var description = tinymce.get('disdescription' + discountGroupId).getContent();
     var discount_pre = document.getElementById('discount_pre' + discountGroupId).value;

     // Create a FormData object to send the data
     var formData = new FormData();
     formData.append('title', title);
     formData.append('description', description);
     formData.append('discount_pre', discount_pre);
     formData.append('discount_group_id', discountGroupId);

     // Create an XMLHttpRequest object to send the data
     var xhr = new XMLHttpRequest();
     xhr.open('POST', 'process/updateDiscountGroup.php', true);

     // Set up the callback function to handle the response
     xhr.onload = function () {
          if (xhr.status === 200) {
               // Show a success message using SweetAlert
               Swal.fire({
                    title: 'Success',
                    text: 'Discount Group updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
               }).then(() => {
                    // Optionally close the modal after the update
                    $('#disdetilModal' + discountGroupId).modal('hide');
                    location.reload();
                    // Optionally, update the UI with new values (e.g., update title/description on the page)
               });
          } else {
               // Show an error message using SweetAlert
               Swal.fire({
                    title: 'Error',
                    text: 'There was an error updating the Discount Group.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
               });
          }
          location.reload();
     };

     // Send the form data to the server
     xhr.send(formData);
}

// Disable Discount function with "Are you sure?" confirmation
function disablediscoun(disgroupId) {
     // Show confirmation dialog using SweetAlert
     Swal.fire({
          title: 'Are you sure?',
          text: "You are about to disable this discount!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, Disable it!',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               // Create a new XMLHttpRequest object
               var xhr = new XMLHttpRequest();

               // Define the URL and method (POST)
               xhr.open("POST", "process/disableDiscount.php", true);

               // Set the Content-Type header for sending form data
               xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

               // Define what happens when the request is completed
               xhr.onload = function () {
                    if (xhr.status === 200) {
                         var response = xhr.responseText.trim();  // Get the response text from the server
                         if (response === 'success') {
                              // Inform the user about the successful operation
                              Swal.fire({
                                   title: 'Success!',
                                   text: 'Discount has been disabled.',
                                   icon: 'success',
                                   confirmButtonText: 'Ok'
                              }).then(function () {
                                   // Reload the page or update UI accordingly
                                   location.reload();
                              });
                         } else {
                              Swal.fire({
                                   title: 'Error!',
                                   text: 'Something went wrong.',
                                   icon: 'error',
                                   confirmButtonText: 'Try Again'
                              });
                         }
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: 'Server error occurred.',
                              icon: 'error',
                              confirmButtonText: 'Try Again'
                         });
                    }
               };

               // Define what happens if there's an error
               xhr.onerror = function () {
                    Swal.fire({
                         title: 'Error!',
                         text: 'Network error occurred.',
                         icon: 'error',
                         confirmButtonText: 'Try Again'
                    });
               };

               // Send the request with the data
               var data = "discount_group_id=" + encodeURIComponent(disgroupId);
               xhr.send(data);  // Send the POST data
          }
     });
}

// Delete Discount function with "Are you sure?" confirmation
function deletdiscoun(disgroupId) {
     // Show confirmation dialog using SweetAlert
     Swal.fire({
          title: 'Are you sure?',
          text: "This discount will be permanently deleted!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, Delete it!',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               // Create a new XMLHttpRequest object
               var xhr = new XMLHttpRequest();

               // Define the URL and method (POST)
               xhr.open("POST", "process/deleteDiscount.php", true);

               // Set the Content-Type header for sending form data
               xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

               // Define what happens when the request is completed
               xhr.onload = function () {
                    if (xhr.status === 200) {
                         var response = xhr.responseText;  // Get the response text from the server
                         alert(response);  // Alert the raw response from PHP

                         if (response.trim() === 'success') {
                              Swal.fire({
                                   title: 'Deleted!',
                                   text: 'The discount has been deleted.',
                                   icon: 'success',
                                   confirmButtonText: 'Ok'
                              }).then(function () {
                                   // Reload the page or update UI accordingly
                                   location.reload();
                              });
                         } else {
                              Swal.fire({
                                   title: 'Error!',
                                   text: 'Something went wrong.',
                                   icon: 'error',
                                   confirmButtonText: 'Try Again'
                              });
                         }
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: 'Server error occurred.',
                              icon: 'error',
                              confirmButtonText: 'Try Again'
                         });
                    }
               };

               // Define what happens if there's an error
               xhr.onerror = function () {
                    Swal.fire({
                         title: 'Error!',
                         text: 'Network error occurred.',
                         icon: 'error',
                         confirmButtonText: 'Try Again'
                    });
               };

               // Send the request with the data
               var data = "discount_group_id=" + encodeURIComponent(disgroupId);
               xhr.send(data);  // Send the POST data
          }
     });
}
function adtodiscount(batch_id, discount_id) {
     let qtyInput = document.getElementById("qtydisbach" + batch_id + discount_id);
     let EpercentageInput = document.getElementById("EpercentageInput" + discount_id).value;
     let startdate = document.getElementById("startdate" + discount_id).value;
     let enddate = document.getElementById("enddate" + discount_id).value;

     let qty = qtyInput ? qtyInput.value : 1;

     // Validate quantity
     if (qty < 1) {
          Swal.fire({
               icon: "error",
               title: "Invalid Quantity",
               text: "Please enter a valid quantity.",
               confirmButtonColor: "#d33",
          });
          return;
     }

     // AJAX Request
     let xhr = new XMLHttpRequest();
     xhr.open("POST", "process/newbachfordis.php", true);
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

     xhr.onload = function () {
          if (xhr.status === 200) {
               Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: xhr.responseText,
                    confirmButtonColor: "#28a745",
               });
          } else {
               Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to add batch to discount.",
                    confirmButtonColor: "#d33",
               });
          }
     };

     xhr.onerror = function () {
          Swal.fire({
               icon: "error",
               title: "Network Error",
               text: "Failed to send request.",
               confirmButtonColor: "#d33",
          });
     };

     // Send request
     let params = "batch_id=" + batch_id + "&discount_id=" + discount_id + "&qty=" + qty + "&EpercentageInput=" + EpercentageInput + "&startdate=" + startdate + "&enddate=" + enddate;
     xhr.send(params);
}

function upnewdisimg(discountId) {
     let formData = new FormData();
     let fileInput = document.querySelector(`#changeImageModal${discountId} input[name="new_image"]`);

     if (!fileInput.files.length) {
          Swal.fire({
               icon: "warning",
               title: "No Image Selected",
               text: "Please select an image before uploading!",
          });
          return;
     }

     formData.append("discountId", discountId);
     formData.append("new_image", fileInput.files[0]);

     fetch("process/newbachfordisimg.php", {
          method: "POST",
          body: formData,
     })
          .then(response => response.text())
          .then(data => {
               Swal.fire({
                    icon: "success",
                    title: "Image Updated!",
                    text: "The image has been successfully uploaded.",
                    confirmButtonColor: "#28a745",
               }).then(() => {
                    location.reload(); // Refresh page to update the image
               });
          })
          .catch(error => {
               Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text: "Something went wrong! Please try again.",
               });
          });
}
function deleteProduct(productID) {
     Swal.fire({
          title: 'Are you sure?',
          text: "Once deleted, you cannot recover this product!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               // Show processing alert
               Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we delete the product.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
               });

               const xhr = new XMLHttpRequest();
               xhr.open('POST', 'process/productdelete.php', true);
               xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

               xhr.onload = function () {
                    // Close processing alert
                    Swal.close();

                    if (xhr.status >= 200 && xhr.status < 300) {
                         Swal.fire({
                              title: 'Deleted!',
                              text: xhr.responseText,
                              icon: 'success'
                         }).then(() => {
                              // Reload the page after deletion confirmation
                              window.location.reload();
                         });
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: xhr.responseText || 'Request failed',
                              icon: 'error'
                         });
                    }
               };

               xhr.onerror = function () {
                    // Close processing alert
                    Swal.close();

                    Swal.fire({
                         title: 'Network Error!',
                         text: 'Failed to send request',
                         icon: 'error'
                    });
               };

               xhr.send('productID=' + encodeURIComponent(productID));
          }
     });
}

function deletebatch(batch_id) {
     Swal.fire({
          title: 'Are you sure?',
          text: "Once deleted, you will not be able to recover this batch!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
     }).then((result) => {
          if (result.isConfirmed) {
               // Show waiting alert
               Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we delete the batch.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
               });

               const xhr = new XMLHttpRequest();
               xhr.open('POST', 'process/batchdelete.php', true);
               xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

               xhr.onload = function () {
                    // Close waiting alert
                    Swal.close();

                    if (xhr.status >= 200 && xhr.status < 300) {
                         Swal.fire({
                              title: 'Deleted!',
                              text: xhr.responseText,
                              icon: 'success'
                         }).then(() => {
                              // Reload the page after deletion confirmation
                              window.location.reload();
                         });
                    } else {
                         Swal.fire({
                              title: 'Error!',
                              text: xhr.responseText || 'Request failed',
                              icon: 'error'
                         });
                    }
               };

               xhr.onerror = function () {
                    // Close waiting alert
                    Swal.close();

                    Swal.fire({
                         title: 'Network Error!',
                         text: 'Failed to send request',
                         icon: 'error'
                    });
               };

               xhr.send('batch_id=' + encodeURIComponent(batch_id));
          }
     });
}
