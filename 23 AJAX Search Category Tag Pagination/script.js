console.log("Hello Aditya");

let currentPage = 1;

// function to fetch posts for a specific page

function fetchPosts(page = 1) {
  jQuery.ajax({
    url: ajax_object.ajax_url,
    type: "POST",
    dataType: "json",
    data: {
      action: "fetch_posts_ajax",
      security: ajax_object.nonce,
      page: page, //send page number to PHP
      category: jQuery("#category-filter").val(),
      tag: jQuery("#tag-filter").val(),
      search: jQuery("#search-input").val(),
    },
    beforeSend: function () {
      console.log("Fetching Posts...");
      jQuery(".post").html("Fetching Posts...");
    },
    success: function (response) {
      console.log("Posts Received: ", response);

      let html = "";

      if (response.posts.length === 0) {
        html += "<p> No Blog Post Found </p>";
        jQuery(".pagination").html(""); // hide pagination
      } else {
        response.posts.forEach((post) => {
          html += `<div class="post-card">
                    <h2>${post.title}</h2>
                    <p>${post.excerpt}</p>
                    <small>${post.date} by ${post.author}</small>
                </div>`;
        });
      }

      jQuery(".post").html(html);

      //   Handle Pagination buttons
      let paginationHTML = "";

      if (response.max_pages > 1) {
        if (response.current_page > 1) {
          paginationHTML += `<button class="pagination-btn" data-page="${
            response.current_page - 1
          }">Previous</button>`;
        }

        for (let i = 1; i <= response.max_pages; i++) {
          paginationHTML += `<button class="pagination-btn ${
            i === response.current_page ? "active" : ""
          }" data-page="${i}">${i}</button>`;
        }
        if (response.current_page < response.max_pages) {
          paginationHTML += `<button class="pagination-btn" data-page="${
            response.current_page + 1
          }">Next</button>`;
        }

        jQuery(".pagination").html(paginationHTML);
      }
    },
    error: function (xhr, status, error) {
      console.log("Error Fetching posts: ", error);
    },
  });
}

jQuery(document).ready(function ($) {
  console.log("Hello From JQUERY");

  fetchPosts(currentPage); //load first page when site loads
  // handle clicks on pagination buttons
  $(document).on("click", ".pagination-btn", function () {
    currentPage = parseInt($(this).data("page"));
    fetchPosts(currentPage);
  });

  $("#category-filter, #tag-filter").on("change", function () {
    currentPage = 1; //reset to page 1
    fetchPosts(currentPage);
  });

  $("#search-input").on("input", function () {
    currentPage = 1;
    fetchPosts(currentPage);
  });
});
/* 

This:

Sends POST to admin-ajax.php

Adds action name and nonce

Handles JSON response
*/
