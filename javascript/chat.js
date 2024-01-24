/*
  Handles message sending, UI updates, and automatic retrieval of chat messages.
*/

// DOM Elements Selection
// Selects DOM elements such as the message form, input field, send button, and chat box.
const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector("button"),
  chatBox = document.querySelector(".chat-box");

// Prevents the default form submission action to handle message sending via AJAX.
form.onsubmit = (e) => {
  e.preventDefault();
};

// Input Field Focus and Button Activation
// Automatically focuses on the message input field when the chat window is active.
inputField.focus();
// Toggles the send button's 'active' class based on whether the input field is empty or not.
inputField.onkeyup = () => {
  if (inputField.value != "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};

// Message Sending via AJAX
// Sends the typed message to php/insert-chat.php using an XMLHttpRequest when the send button is clicked.
sendBtn.onclick = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Clears the input field and auto-scrolls to the bottom of the chat box upon successful message sending.
      if (xhr.status === 200) {
        inputField.value = "";
        scrollToBottom();
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};

// Chat Box Interaction Handling
// Adds or removes an 'active' class to the chat box on mouse enter and leave events, respectively.
chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

// Automatic Chat Update
// Periodically sends AJAX requests to php/get-chat.php every 500 milliseconds to retrieve new chat messages.
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/get-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Updates the chat box with the received data
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        // and scrolls to the bottom unless the user is actively viewing previous messages.
        if (!chatBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + incoming_id);
}, 500);

// Scroll to Bottom Function
// Defines a function scrollToBottom to keep the chat view scrolled to the latest message.
function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
