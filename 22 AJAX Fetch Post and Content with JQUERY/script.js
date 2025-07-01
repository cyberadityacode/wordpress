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

  // Fetch WP Posts

  $("#load-posts-btn").on("click", function () {
    $("#load-posts-btn").text("Fetching...");
    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: {
        action: "fetch_posts",
      },
      success: function (response) {
        $("#posts-container").html(response);
      },
      error: function (error) {
        console.log("Error: ", error);
      },
      complete: function () {
        $("#load-posts-btn").hide();
      },
    });
  });

  // click on post title to load full content

  $(document).on("click", ".post-link", function (e) {
    e.preventDefault();

    const postId = $(this).data("id");
    const postTitle = $(this).text(); //get the title text

    // const $container = $(this).closest("h3").next(); //display under title

    $("#posts-container").html("loading post content...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: {
        action: "get_post_content",
        nonce: ajax_object.nonce,
        post_id: postId,
      },
      success: function (response) {
        if (response.success) {
          $("#posts-container").html(
            "<h3>" + postTitle + "</h3>" + response.data
          );
        } else {
          $("#posts-container").html(
            "<h3>" + postTitle + "</h3>" + "<p>Error Loading post content </p>"
          );
        }
      },
      error: function () {
        $("#posts-container").html("AJAX Request failed");
      },
    });
  });
  /*  $(document).on("click", ".post-link", function (e) {
    e.preventDefault();

    const postId = $(this).data("id");
    const $container = $(this).closest("h3").next(); //display under title

    $container.html("loading post content...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: {
        action: "get_post_content",
        nonce: ajax_object.nonce,
        post_id: postId,
      },
      success: function (response) {
        if (response.success) {
          $container.html(response.data);
        } else {
          $container.html("Error Loading post content");
        }
      },
      error: function () {
        $container.html("AJAX Request failed");
      },
    });
  }); */
});
