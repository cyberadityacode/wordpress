console.log("hello aditya");

jQuery(document).ready(function ($) {
  $("#ajax-button").click(function () {
    $.ajax({
      url: ajax_object.ajax_url, //wp ajax handler
      type: "POST",
      data: {
        action: "my_ajax_action", //This matches the PHP function
        message: "hello from the button",
      },
      success: function (response) {
        $("#ajax-result").html(response);
      },
      error: function () {
        $("#ajax-result").html("Something went wrong");
      },
    });
  });
});
