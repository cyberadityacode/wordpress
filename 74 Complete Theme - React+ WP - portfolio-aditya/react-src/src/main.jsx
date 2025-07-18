import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.jsx";
import AboutComponent from "../components/AboutComponent.jsx";
import NavBar from "../components/NavBar.jsx";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const aboutRoot = document.getElementById("react-root-about");
if (aboutRoot) {
  createRoot(aboutRoot).render(<AboutComponent />);
}

const homeRoot = document.getElementById("react-root");
const navRoot = document.getElementById("react-root-nav");

if (navRoot) {
  createRoot(navRoot).render(<NavBar />);
}

if (homeRoot) {
  createRoot(homeRoot).render(
    <StrictMode>
      <App />
    </StrictMode>
  );
}
