

// Attach the login function to the submit event of the login form
const loginForm = document.getElementById("login-form");
loginForm.addEventListener("submit", login);


document.addEventListener("DOMContentLoaded", () => {
  const errorMessage = document.getElementById("error-message");
  const loginform = document.getElementById("login-form");


  if (!loginform) {
    console.error("Form with id='login-form' not found.");
    return;
  }


  loginform.addEventListener("submit", login);
  errorMessage.style.display = "none";


  function login(event) {
    event.preventDefault();

  
    const email = document.getElementById("email")?.value.trim();
    const password = document.getElementById("password")?.value;
   

    errorMessage.style.display = "none";
    errorMessage.textContent = "";

    if (!email) {
      showError("Email cannot be empty.");
      return;
    }

    if (!password) {
      showError("Password cannot be empty.");
      return;
    }


    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      showError("Please enter a valid email address.");
      return;
    }

    if (password.length < 8) {
      showError("Password must be at least 8 characters long.");
      return;
    }

    // Validation passed
    loginform.submit();
  }

  function showError(message) {
    errorMessage.style.display = "block";
    errorMessage.textContent = message;
  }
});