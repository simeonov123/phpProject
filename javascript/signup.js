/*
  JavaScript AJAX Sign-Up Form Handling
  This JavaScript code snippet is designed to handle a sign-up form in a webpage. 
  It uses AJAX to submit the form data to a server-side script (signup.php) and processes the response.
*/

//Form Selection and Variables
  //Selects the sign-up form element
const form = document.querySelector(".signup form"),
  //Selects the submit button within the form
continueBtn = form.querySelector(".button input"),
  //Selects the element to display error messages.
errorText = form.querySelector(".error-text");

//Form Submission Handling
  //Prevents the default form submission to allow AJAX handling.
form.onsubmit = (e)=>{
    e.preventDefault();
}

//AJAX Request
  //Defines the action when the submit button is clicked.
continueBtn.onclick = ()=>{
      //"XMLHttpRequest" Used to make an asynchronous request to php/signup.php
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/signup.php", true);
      //Defines a callback function that handles the server response.
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
                  //Redirects to users.php if the response is "success".
              if(data === "success"){
                location.href="users.php";
              }else{
                  //Displays an error message if the response is anything other than "success".
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }

    //Form Data Handling
    let formData = new FormData(form);
      //FormData(form): Captures and prepares the form data for sending.
    xhr.send(formData);
}