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
     let description = document.getElementById("desc").value;
     let consignmentStock = document.getElementById("flexCheckChecked").checked ? 1 : 0;

     // Image inputs
     let img1 = document.getElementById("img_input_1").files[0];
     let img2 = document.getElementById("img_input_2").files[0];
     let img3 = document.getElementById("img_input_3").files[0];

     // Validate input fields
     if (!title || productGroup == "0" || category == "0" || condition == "0" || status == "0" || !weight) {
          alert("Please fill all required fields.");
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

     if (img1) formData.append("img1", img1);
     if (img2) formData.append("img2", img2);
     if (img3) formData.append("img3", img3);

     let xhr = new XMLHttpRequest();
     xhr.open("POST", "product_add_pro.php", true);
     xhr.onload = function () {
          if (this.status == 200) {
               alert(this.responseText);
          }
     };
     xhr.send(formData);
}
