document
  .getElementById("placeOders")
  .addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor action
    const button = document.getElementById("placeOders");

    let isValid = true;
    let form = document.getElementById("placeOdersForm");
    let formData = new FormData(form);
    let dataObject = {};
    let totalValue =
      parseFloat(
        document
          .getElementById("totalPrice")
          .innerText.replace("Rs ", "")
          .trim()
      ) || 0;

    if (!(totalValue > 0)) {
      isValid = false;
      Swal.fire({
        icon: "error",
        title: "Invalid Order",
        text: "Total order value must be greater than 0!",
      });
      return;
    }

    if (!isValid) return;
    let logedUserEmail = document.getElementById("userEmail").value.trim();
    let optionalFields = ["address2", "additional_info"];
    let paymentMethod = document.querySelector('input[name="payment"]:checked');

    formData.forEach((value, key) => {
      let inputField = document.querySelector(`[name="${key}"]`);

      // Check if the field is optional
      if (optionalFields.includes(key)) {
        dataObject[key] = value;
        return;
      }

      // Validate required fields
      if (value.trim() === "") {
        isValid = false;
        showError(inputField, `${formatKey(key)} is required`);
      } else {
        removeError(inputField);
      }

      dataObject[key] = value;
    });

    console.log("Form Data:", dataObject);

    // Submit the form only if all required fields are valid
    if (isValid) {
      button.disabled = true; // Disable the button
      button.innerText = "Ordering..."; // Change text

      if (!paymentMethod || paymentMethod.id == "payment2") {
        // Add total value and email to the data object
        dataObject["total_value"] = totalValue;
        dataObject["logedUserEmail"] = logedUserEmail;

        // Send data to the backend using Fetch API
        fetch("placeOdersBackend/process_order.php", {
          method: "POST",
          body: JSON.stringify(dataObject),
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "success") {
              console.log(data.paymentData);
              submitPayment(data.paymentData, data.pay_url);
            } else {
              Swal.fire({
                icon: "error",
                title: "Order Failed",
                text: "Error placing order: " + data.message,
              });

              button.disabled = false; // Re-enable the button
              button.innerText = "Place Order"; // Reset text
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
              icon: "error",
              title: "Oops!",
              text: "An error occurred while processing your order.",
            });

            button.disabled = false; // Re-enable the button
            button.innerText = "Place Order"; // Reset text
          });
      }
    }
  });

function submitPayment(paymentData, pay_url) {
  let form = document.createElement("form");
  form.method = "POST";
  form.action = pay_url;

  for (let key in paymentData) {
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = key;
    input.value = paymentData[key];
    form.appendChild(input);
  }

  document.body.appendChild(form);
  form.submit();
}

// Function to show an error message
function showError(input, message) {
  if (!input) return; // Avoid errors if the input field doesn't exist

  let errorSpan = input.nextElementSibling;

  if (!errorSpan || !errorSpan.classList.contains("error-message")) {
    errorSpan = document.createElement("span");
    errorSpan.classList.add("error-message");
    errorSpan.style.color = "red";
    input.parentNode.appendChild(errorSpan);
  }

  errorSpan.textContent = message;
}

// Function to remove error message
function removeError(input) {
  if (!input) return;

  let errorSpan = input.nextElementSibling;
  if (errorSpan && errorSpan.classList.contains("error-message")) {
    errorSpan.remove();
  }
}

// Function to format field names (e.g., "first_name" -> "First Name")
function formatKey(key) {
  return key.replace(/_/g, " ").replace(/\b\w/g, (char) => char.toUpperCase());
}
