import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
    minify: false,
    outDir: path.resolve(__dirname, "build"),
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, "src/main.jsx"),
      output: {
        entryFileNames: "index.js",
      },
    },
  },
});
