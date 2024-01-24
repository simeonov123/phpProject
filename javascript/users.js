/*
  The users.js script is responsible for adding interactive search functionality to the user list 
  on a webpage and periodically updating the user list without page refreshes.
*/

// Elements Selection
// The input field where the user types the search query.
const searchBar = document.querySelector(".search input"),
  // The button that the user clicks to toggle the search input.
  searchIcon = document.querySelector(".search button"),
  // The container where the user list is displayed.
  usersList = document.querySelector(".users-list");

// Search Icon Click Event
// If the searchBar doesn't contain the "active" class when clicked, the classes of the search bar and icon will change
// the visibility of the search input and the appearance of the button to indicate it's active.
// The search input is focused, allowing the user to start typing immediately.
// If the "searchBar" already contains the "active" class, the input is cleared, and the "active" class is removed.
searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

// Search Input Keyup Event
searchBar.onkeyup = () => {
  // The "keyup" event on "searchTerm" captures the current value of the search input in the "searchTerm" variable.
  let searchTerm = searchBar.value;
  if (searchTerm != "") {
    // If "searchTerm" is not empty, the "active" class is added to "searchBar".
    searchBar.classList.add("active");
  } else {
    // If "searchTerm" is empty, the "active" class is removed.
    searchBar.classList.remove("active");
  }
  // An AJAX POST request is made to "php/search.php" with the "searchTerm".
  // XMLHttpRequest object xhr is used to handle the AJAX.
  let xhr = new XMLHttpRequest();
  // The request is opened with method "POST" and the URL php/search.php.
  xhr.open("POST", "php/search.php", true);
  // On load, the response is checked for ready state and status code 200.
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // The response from "search.php" is set as the inner HTML of "userList", updating the user list with the search results.
        let data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

// Periodic User List Update
// The script sets an interval to run a function every 500 milliseconds.
setInterval(() => {
  // Makes an AJAX GET request to php/users.php.
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // On successful response, checks if searchBar does not contain the active class.
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          // If not active, updates usersList's inner HTML with the response data, which is the updated user list.
          usersList.innerHTML = data;
        }
      }
    }
  };
  xhr.send();
}, 500);
