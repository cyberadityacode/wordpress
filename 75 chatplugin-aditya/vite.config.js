import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path'

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: path.resolve(__dirname, 'build/assets'), // outside chat-ui
    emptyOutDir: true,
    rollupOptions: {
      input: './src/main.jsx',
      output: {
        entryFileNames: `index.js`,
        assetFileNames: `index.css`
      }
    }
  }
})
