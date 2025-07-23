console.log("Welcome to myawesomeplugin");

console.log("Hello World");

const username = document.getElementById("username");
const buttonUsername = document.getElementById("sendButton");

buttonUsername.addEventListener("click", function () {
  alert(username.value);
});

// myawesomeplugin_hello

fetch(ajaxurl + "?action=myawesomeplugin_hello")
  .then((res) => res.json())
  .then((data) => console.log(data));

jQuery(document).ready(function ($) {
  $.ajax({
    url: ajaxurl, // WordPress provides this in admin, or localize in frontend
    method: "POST",
    data: {
      action: "myawesomeplugin_fetch_users",
    },
    success: function (response) {
      if (response.success) {
        console.log("Users:", response.data);
        // You can render user data to HTML here
      } else {
        console.error("Failed to fetch users");
      }
    },
    error: function (error) {
      console.error("AJAX Error:", error);
    },
  });
});
