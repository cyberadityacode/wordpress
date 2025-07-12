import React, { useState } from "react";

export default function App() {
  const [imageURL, setImageURL] = useState("");
  const [message, setMessage] = useState("");

  const openMediaLibrary = () => {
    const frame = window.wp.media({
      title: "Select Image",
      multiple: false,
      library: { type: "image" },
      button: { text: "Use This Image" },
    });

    frame.on("select", () => {
      const attachment = frame.state().get("selection").first().toJSON();
      setImageURL(attachment.url);
    });

    frame.open();
  };

  const handleSave = async () => {
    try {
      const response = await fetch(riu_data.ajaxurl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: "riu_save_image",
          nonce: riu_data.nonce,
          image_url: imageURL,
        }),
      });

      const data = await response.json();
      console.log(data);
      if (data.success) {
        setMessage("✅" + data.data.message);
      } else {
        setMessage("❌" + data.data.message);
      }
    } catch (error) {
      console.error(error);
      setMessage("❌ Something Went Wrong");
    }
  };
  return (
    <div>
      <h2>Upload and Save Image</h2>

      <button onClick={openMediaLibrary}>Select Image</button>

      {imageURL && (
        <div style={{ marginTop: "1rem" }}>
          <img src={imageURL} alt="Selected" style={{ maxWidth: "30px" }} />
          <br />
          <button onClick={handleSave} style={{ marginTop: "1rem" }}>
            Save Image
          </button>
        </div>
      )}
      {message && <p style={{ marginTop: "1rem" }}>{message}</p>}
    </div>
  );
}
