import React, { useEffect, useState } from "react";
import "../App.css";
import MessageList from "./MessageList";
import MessageForm from "./MessageForm";

export default function ChatApp() {
  const [messages, setMessages] = useState([
    { text: "Loading Messages... ", from: "bot" },
  ]);

  const addMessage = (msg) => {
    // Optional: Send to backend here (we’ll do this in Day 9)
    setMessages((prev) => [...prev, msg]);
  };

  const fetchOldMessages = async () => {
    try {
      const res = await fetch("/wpaditya/wp-json/chat/v1/messages");
      const data = await res.json();

      const formatted = data.map((msg) => ({
        text: msg.message,
        from: msg.sender,
      }));

      setMessages(formatted);
    } catch (error) {
      console.error("Failed to fetch messages:", error);
      setMessages([{ text: "Failed to Load Messages", from: "bot" }]);
    }
  };

  useEffect(() => {
    setInterval(() => {
      fetchOldMessages();
    }, 3000);
  }, []);

  return (
    <div className="chat-box">
      <MessageList messages={messages} />
      <MessageForm onSend={addMessage} />
    </div>
  );
}
