import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'

createRoot(document.getElementById('chatplugin-root')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
