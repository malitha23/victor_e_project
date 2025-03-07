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
