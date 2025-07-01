import React from "react";
import { useState } from "react";

export default function App() {
  const [response, setResponse] = useState("");

  const handleClick = () => {
    const formData = new FormData();
    formData.append("action", "my_ajax_action");
    formData.append("message", "Hello from React");

    fetch(window.ajax_object.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => setResponse(data))
      .catch((err) => setResponse("Error: " + err.message));
  };

  return (
    <div>
      <h2>React AJAX Example</h2>
      <button onClick={handleClick}>Send AJAX Request</button>
      <div>{response}</div>
    </div>
  );
}
