/*
  Password Visibility Toggle JavaScript Function Documentation
  This JavaScript code snippet provides functionality to toggle the visibility of a password field in a form. 
  It changes the type of the input field from password to text and vice versa, 
  allowing the user to show or hide their password.
*/

// Element Selection
// Selects the password input field within a form.
const pswrdField = document.querySelector(".form input[type='password']"),
  // Selects the icon element used to toggle the password
  toggleIcon = document.querySelector(".form .field i");

// Event Handling
// An event listener that triggers when the toggle icon is clicked.
toggleIcon.onclick = () => {
  // Changes the type of pswrdField between text and password.
  // Adds or removes the active class to toggleIcon to visually indicate the toggle state.
  if (pswrdField.type === "password") {
    pswrdField.type = "text";
    toggleIcon.classList.add("active");
  } else {
    pswrdField.type = "password";
    toggleIcon.classList.remove("active");
  }
};
