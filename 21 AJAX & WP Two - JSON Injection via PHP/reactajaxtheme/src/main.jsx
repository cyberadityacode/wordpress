import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.jsx";

const root = document.getElementById("root");

// read and parse data

const dataScript = document.getElementById("initial-data");
let initialData = {};

if (dataScript) {
  try {
    initialData = JSON.parse(dataScript.textContent);
  } catch (e) {
    console.error("failed to parse initial data");
  }
}

createRoot(root).render(
  <StrictMode>
    <App initialData={initialData} />
  </StrictMode>
);
