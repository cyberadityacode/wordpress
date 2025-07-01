console.log("Hello Aditya");

// jQuery(function)

jQuery(document).ready(function ($) {
  $("#btn-jquery").on("click", function (e) {
    e.preventDefault();

    //loading text
    $("#output").html("Loading...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: {
        action: "my_custom_action",
        nonce: ajax_object.nonce,
        message: "hello from frontend",
      },
      success: function (response) {
        console.log("Server Says: ", response);

        if (response.success) {
          $("#output").html(response.data);
        } else {
          $("#output").html("Something Went wrong");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#output").html("AJAX Request Failed");
      },
    });
  });
});
