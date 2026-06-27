document.addEventListener("DOMContentLoaded", () => {
  const errorMessage = document.getElementById("error-message");
  const addUserForm = document.getElementById("login-form");
const validCourses = [
    "BSIT",
    "BSA",
    "BSBA",
    "BSED",
    "BEED",
    "BSHM",
    "BSN",
    "BSCRIM",
    "BSCE"
];


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
    const course = document.getElementById("course")?.value.trim();
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
    if (!course) {
      showError("course cannot be empty.");
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
    const lowercaseCourses = validCourses.map(course => course.toLowerCase());
    if (lowercaseCourses.includes(course)) {
          showError("Course is valid but it should be uppercase.");
          return;
        }
    if (course !== course.toUpperCase()) {
      showError("Course should be uppercase.");
      return;
    }
    if (!validCourses.includes(course)) {
        showError("Please select a valid course.");
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

const courses = [
    {
        code: "BSIT",
        name: "Bachelor of Science in Information Technology"
    },
    {
        code: "BSA",
        name: "Bachelor of Science in Accountancy"
    },
    {
        code: "BSBA",
        name: "Bachelor of Science in Business Administration"
    },
    {
        code: "BSED",
        name: "Bachelor of Secondary Education"
    },
    {
        code: "BEED",
        name: "Bachelor of Elementary Education"
    },
    {
        code: "BSHM",
        name: "Bachelor of Science in Hospitality Management"
    },
    {
        code: "BSN",
        name: "Bachelor of Science in Nursing"
    },
    {
        code: "BSCRIM",
        name: "Bachelor of Science in Criminology"
    },
    {
        code: "BSCE",
        name: "Bachelor of Science in Civil Engineering"
    }
];
const courseInput = document.getElementById("course");
const suggestions = document.getElementById("courseSuggestions");

courseInput.addEventListener("input", () => {
    const search = courseInput.value.trim().toLowerCase();

    suggestions.innerHTML = "";

    if (!search) {
        suggestions.style.display = "none";
        return;
    }

    const matches = courses.filter(course =>
        course.code.toLowerCase().includes(search) ||
        course.name.toLowerCase().includes(search)
    );

    if (!matches.length) {
        suggestions.style.display = "none";
        return;
    }

    matches.forEach(course => {

        const item = document.createElement("div");
        item.className = "suggestion-item";

        // Show both
        item.textContent = `${course.code} - ${course.name}`;

        item.addEventListener("click", () => {

            // Only insert the code
            courseInput.value = course.code;

            suggestions.innerHTML = "";
            suggestions.style.display = "none";

        });

        suggestions.appendChild(item);

    });

    suggestions.style.display = "block";
});

document.addEventListener("click", e => {

    if (!e.target.closest(".course-container")) {

        suggestions.innerHTML = "";
        suggestions.style.display = "none";

    }

});