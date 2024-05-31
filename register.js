function register(event) {
  event.preventDefault(); // Prevent form submission

  const form = document.querySelector('form');
  const successMessageElement = document.getElementById("successMessage");

  const name = form.querySelector('input[name="name"]').value;
  const orgName = form.querySelector('input[name="orgname"]').value;
  const designation = form.querySelector('input[name="designation"]').value;
  const contact = form.querySelector('input[name="contact"]').value;
  const email = form.querySelector('input[name="email"]').value;
  const city = form.querySelector('input[name="city"]').value;
  const state = form.querySelector('input[name="state"]').value;
  const pincode = form.querySelector('input[name="pincode"]').value;

  function showModal(message) {
      const modal = document.getElementById("myModal");
      const modalMessage = document.getElementById("modalMessage");

      modalMessage.textContent = message;
      modal.style.display = "block";

      // Close the modal when the user clicks the close button
      const closeModalButton = document.getElementById("closeModal");
      closeModalButton.addEventListener("click", function () {
          modal.style.display = "none";
      });
  }

  // Create an object with the user data
  const userData = {
      name: name,
      orgname: orgName,
      designation: designation,
      contact: contact,
      email: email,
      city: city,
      state: state,
      pincode: pincode
  };

  fetch("register.php", {
      method: "POST",
      body: JSON.stringify(userData),
      headers: {
          "Content-Type": "application/json"
      }
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === 'success') {
          showModal("The event registration process has been successfully completed. Your safety is our utmost priority, and we look forward to hosting you at the event with the highest regard");
      } else {
          console.error(data.message);
          showModal("Registration failed: " + data.message);
      }
  })
  .catch(error => {
      console.error("Error:", error);
      showModal("An error occurred during registration: " + error.message);
  });
  form.reset();
}

// Get the city input field element
var cityInput = document.getElementById("cityInput");

// Get the state input field element
var stateInput = document.getElementById("stateInput");

// Attach a blur event listener to the city input field
cityInput.addEventListener("blur", function () {
  // Get the value of the city input field
  var city = cityInput.value.trim();

  // Check if the city input is not empty
  if (city !== "") {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "getState.php?city_name=" + city, true);
      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);

              // Check if there is no error
              if (!response.error) {
                  // Set the state input field value based on the response
                  stateInput.value = response.state_name;
              } else {
                  // Handle the error, e.g., display an error message
                  console.error(response.error);
              }
          }
      };

      // Send the request
      xhr.send();
  }
});
