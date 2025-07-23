console.log("Welcome to myawesomeplugin");

console.log("Hello World");

const username = document.getElementById("username");
const buttonUsername = document.getElementById("sendButton");

buttonUsername.addEventListener("click", function () {
  alert(username.value);
});
