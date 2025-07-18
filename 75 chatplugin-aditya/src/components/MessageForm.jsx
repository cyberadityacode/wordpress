import React, { useState } from "react";

export default function MessageForm({ onSend }) {
  const [input, setInput] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!input.trim()) return;

    onSend({ text: input, from: "user" });
    setLoading(true);

    try {
      const res = await fetch(ChatPluginData.ajaxUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          action: "chatplugin_submit_message",
          message: input,
          nonce: ChatPluginData.nonce,
        }),
      });

      const data = await res.json();
      if (data.success) {
        onSend({ text: data.data.reply, from: "bot" });
      } else {
        onSend({ text: "Bot Failed to reply", from: "bot" });
      }
    } catch (error) {
      console.error(error);
      onSend({ text: "Server Error Occurred ", from: "bot" });
    }

    setInput("");
    setLoading(false);
  };

  return (
    <form className="chat-input" onSubmit={handleSubmit}>
      <input
        type="text"
        value={input}
        onChange={(e) => setInput(e.target.value)}
        placeholder="Type a message..."
      />
      <button type="submit" disabled={loading}>
        {loading ? "Sending..." : "Send"}
      </button>
    </form>
  );
}
