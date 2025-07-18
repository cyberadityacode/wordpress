import React from "react";

export default function ProjectCard({ project }) {
  return (
    <div
      className="project-card"
      style={{
        flex: "0 0 300px", // Fixed width for slider
        scrollSnapAlign: "start",
        border: "1px solid #ccc",
        padding: "1rem",
        borderRadius: "12px",
        backgroundColor: "#fff",
        boxShadow: "0 4px 12px rgba(0, 0, 0, 0.1)",
      }}
    >
      {project.featured_image_url && (
        <div
          style={{
            position: "relative",
            width: "100%",
            paddingBottom: "56.25%", // 16:9 aspect ratio
            marginBottom: "1rem",
            borderRadius: "8px",
            overflow: "hidden",
          }}
        >
          <img
            src={project.featured_image_url}
            alt={project.title.rendered}
            style={{
              position: "absolute",
              top: 0,
              left: 0,
              width: "100%",
              height: "100%",
              objectFit: "cover",
            }}
          />
        </div>
      )}

      <h2
        style={{ fontSize: "1.25rem", marginBottom: "0.5rem" }}
        dangerouslySetInnerHTML={{ __html: project.title.rendered }}
      ></h2>

      <div
        style={{ fontSize: "0.95rem", color: "#444" }}
        dangerouslySetInnerHTML={{ __html: project.excerpt.rendered }}
      ></div>
    </div>
  );
}
