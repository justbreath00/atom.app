const errorMessage = document.getElementById("error-message");

function addUser(event) {
  event.preventDefault();

  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  
  const passwordInput = document.getElementById("password");
  const confirmInput = document.getElementById("confirm");


  const username = usernameInput.value;
  const email = emailInput.value;

  const password = passwordInput.value;
  const confirm = confirmInput.value;

  // Validate inputs
  if (username.trim() === "") {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Username cannot be empty.";
    return;
  }
  if (email.trim() === "") {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Email cannot be empty.";
    return;
  }
  if (password.trim() === "") {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Password cannot be empty.";
    return;
  }
  if (confirm.trim() === "") {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Please confirm your password.";
    return;
  }
  if (password !== confirm) {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Passwords do not match.";
    return;
  }

  const hasSpecialCharacters = /^[a-zA-Z][a-zA-Z0-9_]*$/;
  if (!hasSpecialCharacters.test(username)) {
    errorMessage.style.display = "block";
    errorMessage.textContent =
      "Username must start with an alphabet, and must only contain alphanumeric characters and underscores.";
    return;
  }
  if (!email.includes("@")) {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Please enter a valid email address.";
    return;
  }

  if (password.length < 8) {
    errorMessage.style.display = "block";
    errorMessage.textContent = "Password cannot be less than 8 characters.";
    return;
  }

fetch("register.php", {
    method: "POST",
    credentials: 'include', //cookies 
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `
    &username=${encodeURIComponent(username)}
    &email=${encodeURIComponent(email)}
    &password=${encodeURIComponent(password)}
    &confirm=${encodeURIComponent(confirm)}`,
  })
}


// Attach the login function to the submit event of the login form
const addUserForm = document.getElementById("register-form");
addUserForm.addEventListener("submit", addUser);
