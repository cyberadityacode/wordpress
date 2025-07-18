import React, { useEffect, useState } from "react";
import "../src/App.css";

export default function NavBar() {
  const [menuItems, setMenuItems] = useState([]);
  const [isOpen, setIsOpen] = useState(false); // Toggle menu

  const fetchMenus = async () => {
    try {
      const response = await fetch("/wpaditya/wp-json/custom/v1/menu");
      const data = await response.json();
      setMenuItems(data);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchMenus();
  }, []);

  return (
    <nav className="navbar">
      <div className="navbar-header">
        {/* <div className="brand-title">My Website</div> */}
        <button className="toggle-button" onClick={() => setIsOpen(!isOpen)}>
          &#9776;
        </button>
      </div>

      <ul className={`nav-list ${isOpen ? "active" : ""}`}>
        {menuItems.map((item) => (
          <li key={item.id}>
            <a href={item.url}>{item.title}</a>
          </li>
        ))}
      </ul>
    </nav>
  );
}
