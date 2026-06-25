document.addEventListener("DOMContentLoaded", () => {
  const errorMessage = document.getElementById("error-message");
  const addUserForm = document.getElementById("login-form");


  if (!addUserForm) {
    console.error("Form with id='login-form' not found.");
    return;
  }


  addUserForm.addEventListener("submit", addUser);
  errorMessage.style.display = "none";


  function addUser(event) {
    event.preventDefault();

    const username = document.getElementById("username")?.value.trim();
    const email = document.getElementById("email")?.value.trim();
    const password = document.getElementById("password")?.value;
    const confirm = document.getElementById("confirm_password")?.value;

    errorMessage.style.display = "none";
    errorMessage.textContent = "";

    if (!username) {
      showError("Username cannot be empty.");
      return;
    }

    if (!email) {
      showError("Email cannot be empty.");
      return;
    }

    if (!password) {
      showError("Password cannot be empty.");
      return;
    }

    if (!confirm) {
      showError("Please confirm your password.");
      return;
    }

    if (password !== confirm) {
      showError("Passwords do not match.");
      return;
    }

    const usernamePattern = /^[a-zA-Z][a-zA-Z0-9_]*$/;
    if (!usernamePattern.test(username)) {
      showError(
        "Username must start with a letter and contain only letters, numbers, and underscores."
      );
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
    addUserForm.submit();
  }

  function showError(message) {
    errorMessage.style.display = "block";
    errorMessage.textContent = message;
  }
});