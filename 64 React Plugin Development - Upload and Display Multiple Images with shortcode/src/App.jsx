import React, { useState } from "react";

export default function App() {
  const [images, setImages] = useState([]);
  const [saving, setSaving] = useState(false);

  const openMediaLibrary = () => {
    if (!wp || !wp.media) {
      alert("WordPress media library not available.");
      return;
    }

    const frame = wp.media({
      title: "Select Images",
      multiple: true,
      library: { type: "image" },
      button: { text: "Use Selected Images" },
    });

    frame.on("select", () => {
      const selection = frame.state().get("selection");
      const selectedUrls = selection.map((img) => img.toJSON().url);
      const unique = [...new Set([...images, ...selectedUrls])];
      setImages(unique);
    });

    frame.open();
  };

  const saveGallery = async () => {
    if (images.length === 0) return alert("No images to save.");

    setSaving(true);
    try {
      const response = await fetch(riuData.ajaxurl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: "save_gallery_images",
          nonce: riuData.nonce,
          images: JSON.stringify(images),
        }),
      });

      const data = await response.json();
      alert(data.success ? "Gallery Saved!" : `Error: ${data.data.message}`);
    } catch {
      alert("An error occurred.");
    } finally {
      setSaving(false);
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>React Image Uploader</h2>
      <button onClick={openMediaLibrary}>📁 Select Images</button>
      <button onClick={saveGallery} disabled={saving} style={{ marginLeft: "10px" }}>
        {saving ? "Saving..." : "💾 Save Gallery"}
      </button>
      <p>{images.length} image(s) selected</p>
      <div style={{ display: "flex", flexWrap: "wrap", gap: "10px", marginTop: "20px" }}>
        {images.map((url, i) => (
          <div key={i} style={{ position: "relative" }}>
            <img src={url} width="100" alt="preview" />
            <button
              onClick={() => setImages((prev) => prev.filter((_, index) => index !== i))}
              style={{
                position: "absolute",
                top: 0,
                right: 0,
                background: "red",
                color: "white",
                border: "none",
                borderRadius: "50%",
                cursor: "pointer",
              }}
            >
              ✕
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}
