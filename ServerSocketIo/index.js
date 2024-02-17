import express from "express";
import { createServer } from "node:http";
import { fileURLToPath } from "node:url";
import { dirname, join } from "node:path";
import { Server } from "socket.io";

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: {
    origin: "http://127.0.0.1:8000",
    credentials: true,
  },
});

const __dirname = dirname(fileURLToPath(import.meta.url));

app.get("/", (req, res) => {
  res.sendFile(join(__dirname, "index.html"));
});

io.on("connection", (socket) => {
  console.log("a user connected");

  socket.on("chat message", (msg) => {
    fetch("http://127.0.0.1:8000/api/slide", {
      method: "POST", // Correcting "Method" to "method"
      headers: {
        // Correcting "Headers" to "headers"
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        phone: msg,
      }),
      cache: "default", // Correcting "Cache" to "cache"
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        io.emit("info", data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
    io.emit("chat message", msg);
  });
});

server.listen(3000, () => {
  console.log("server running at http://localhost:3000");
});
