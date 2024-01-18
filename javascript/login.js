/*
    This JavaScript code snippet is designed to handle a login form on a webpage. 
    It uses AJAX (Asynchronous JavaScript and XML) to submit the form data to a server-side script (login.php) 
    without reloading the page, and handles the response to either redirect the user or display an error message.
*/

//Form Selection and Variables
//The form element on the webpage with the class .login form.
const form = document.querySelector(".login form"),
  //The input element of type button used to submit the form.
  continueBtn = form.querySelector(".button input"),
  //The element where error messages will be displayed.
  errorText = form.querySelector(".error-text");

//Form Submission Prevention
//An event handler that prevents the form's default submission behavior, allowing the AJAX call to handle it instead.
form.onsubmit = (e) => {
  e.preventDefault();
};

//AJAX Request Setup
//Defines the action to be taken when the continue button is clicked.
continueBtn.onclick = () => {
  //An object that allows communication with the server without reloading the page.
  let xhr = new XMLHttpRequest();
  //Configures the type of request (POST), the URL (php/login.php), and sets it to be asynchronous (true).
  xhr.open("POST", "php/login.php", true);

  //Response Handling
  //Defines a callback function that is called when the AJAX request completes.
  xhr.onload = () => {
    //Checks if the request operation is complete.
    if (xhr.readyState === XMLHttpRequest.DONE) {
      //Checks if the HTTP request was successful (status code 200).
      if (xhr.status === 200) {
        //Server Response Evaluation
        let data = xhr.response;
        if (data === "success") {
          //If the response is "success", the user is redirected to users.php.
          location.href = "users.php";
        } else {
          //f the response is anything else, the error message is displayed in the errorText element.
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      }
    }
  };

  //Form Data Handling
  //Captures and encodes the form data for sending with the AJAX request.
  let formData = new FormData(form);
  //Sends the form data to the server.
  xhr.send(formData);
};
