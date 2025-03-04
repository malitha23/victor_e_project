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
