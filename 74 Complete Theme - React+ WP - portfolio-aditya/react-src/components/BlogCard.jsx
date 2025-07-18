import React from "react";

export default function BlogCard({ post }) {
  return (
    <div
      className="blog-card"
      style={{ border: "1px solid #ddd", padding: "1rem", borderRadius: "8px" }}
    >
      {post.featured_image_url && (
        <a href={post.link} rel="noopener noreferrer">
          <img
            src={post.featured_image_url}
            alt={post.title.rendered}
            style={{
              maxWidthwidth: "300px",
              maxHeight: "200px",
              borderRadius: "8px",
            }}
          />
        </a>
      )}
      
        <h3 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
        <div dangerouslySetInnerHTML={{ __html: post.excerpt.rendered }} />
     
      <a href={post.link} rel="noopener noreferrer">
        Read More
      </a>
    </div>
  );
}
