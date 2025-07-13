import React, { useEffect, useState } from "react";

export default function App() {
  const [images, setImages] = useState([]);
  const [gallery, setGallery] = useState([]);
  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);

  const fetchGallery = async () => {
    setLoading(true);
    const formData = new FormData();
    formData.append("action", "get_gallery_images");
    formData.append("nonce", riuData.nonce);

    try {
      const res = await fetch(riuData.ajaxurl, {
        method: "POST",
        body: formData,
      });
      const data = await res.json();
      if (data.success) {
        setGallery(data.data);
      } else {
        alert("Failed to load gallery images");
      }
    } catch (err) {
      console.error("Fetch error:", err);
      alert("Error loading gallery");
    }

    setLoading(false);
  };

  useEffect(() => {
    fetchGallery();
  }, []);

  const openMediaLibrary = () => {
    const media = wp.media({
      title: "Select Images",
      multiple: true,
      library: { type: "image" },
      button: { text: "Add Selected Images" },
    });

    media.on("select", () => {
      const selected = media.state().get("selection").toArray();
      const urls = selected.map((img) => img.attributes.url);
      setImages(urls);
    });

    media.open();
  };

  const saveImages = async () => {
    if (images.length === 0) return alert("Please select some images first");

    setSaving(true);
    const formData = new FormData();
    formData.append("action", "save_gallery_images");
    formData.append("nonce", riuData.nonce);
    formData.append("images", JSON.stringify(images));

    try {
      const res = await fetch(riuData.ajaxurl, {
        method: "POST",
        body: formData,
      });

      const data = await res.json();
      if (data.success) {
        alert("Images Saved!");
        setImages([]);
        fetchGallery();
      } else {
        alert(data.data?.message || "Failed to save images");
      }
    } catch (err) {
      console.error("Save error:", err);
      alert("Error saving images");
    }

    setSaving(false);
  };

  const deleteImage = async (id) => {
    if (!confirm("Are you sure to delete?")) return;

    const formData = new FormData();
    formData.append("action", "delete_gallery_image");
    formData.append("nonce", riuData.nonce);
    formData.append("id", id);

    try {
      const res = await fetch(riuData.ajaxurl, {
        method: "POST",
        body: formData,
      });

      const data = await res.json();
      if (data.success) {
        alert("Deleted Successfully");
        fetchGallery();
      } else {
        alert(data.data?.message || "Failed to delete");
      }
    } catch (err) {
      console.error("Delete error:", err);
      alert("Error deleting image");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>📁 Aditya Upload Multiple Images</h2>
      <button onClick={openMediaLibrary}>Choose Images</button>

      {images.length > 0 && (
        <>
          <p>Selected Images:</p>
          {/* <div style={{ display: "flex", gap: "10px", flexWrap: "wrap" }}>
            {images.map((url, i) => (
              <img key={i} src={url} width="100" alt="Selected" />
            ))}
          </div> */}
          <br />
          <button onClick={saveImages} disabled={saving}>
            {saving ? "Saving..." : "Save to Gallery"}
          </button>
        </>
      )}

      <hr />

      <h2>🖼️ Uploaded Images</h2>
      {loading ? (
        <p>Loading...</p>
      ) : (
        <div style={{ display: "flex", flexWrap: "wrap", gap: "15px" }}>
          {gallery.length > 0 ? (
            gallery.map((item) => (
              <div key={item.id} style={{ textAlign: "center" }}>
                <img src={item.image_url} width="100" alt={`Image ${item.id}`} />
                <br />
                <small>ID: {item.id}</small>
                <br />
                <button onClick={() => deleteImage(item.id)}>Delete</button>
              </div>
            ))
          ) : (
            <p>No images found</p>
          )}
        </div>
      )}
    </div>
  );
}
