import React from "react";
import ProjectGrid from "../components/ProjectGrid";
import BlogGrid from "../components/BlogGrid";
import NavBar from "../components/NavBar";
import "./App.css";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import AboutComponent from "../components/AboutComponent";

export default function App() {
  return (
    <div style={{ padding: "2rem" }}>
      {/* <NavBar /> */}
      <AboutComponent />
      <ProjectGrid />
      <BlogGrid />
    </div>
  );
}
