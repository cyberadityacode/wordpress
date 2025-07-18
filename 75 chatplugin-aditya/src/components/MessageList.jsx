import React from "react";

export default function MessageList({ messages }) {
  return (
    <div className="chat-messages">
      {messages.map((msg, idx) => (
        <div key={idx} className={`chat-bubble ${msg.from}`}>
          {msg.text}
        </div>
      ))}
    </div>
  );
}
