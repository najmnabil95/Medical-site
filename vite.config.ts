import path from "path";
import fs from "fs";
import { fileURLToPath } from "url";
import tailwindcss from "@tailwindcss/vite";
import { defineConfig } from "vite";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const hotFile = path.resolve(__dirname, "public/hot");

function laravelHotFile() {
  return {
    name: "laravel-hot-file",
    configureServer(server) {
      const writeHotFile = () => {
        const address = server.httpServer?.address();
        const port = typeof address === "object" && address ? address.port : server.config.server.port;
        fs.writeFileSync(hotFile, `http://127.0.0.1:${port}`);
      };

      const removeHotFile = () => {
        if (fs.existsSync(hotFile)) fs.unlinkSync(hotFile);
      };

      server.httpServer?.once("listening", writeHotFile);
      server.httpServer?.once("close", removeHotFile);
    },
  };
}

export default defineConfig({
  root: __dirname,
  plugins: [tailwindcss(), laravelHotFile()],
  publicDir: false,
  build: {
    outDir: path.resolve(__dirname, "public/build"),
    emptyOutDir: true,
    manifest: "manifest.json",
    rollupOptions: {
      input: [
        path.resolve(__dirname, "resources/css/app.css"),
        path.resolve(__dirname, "resources/js/app.js"),
      ],
    },
  },
  server: {
    host: "127.0.0.1",
    port: 5174,
    strictPort: false,
    proxy: {
      "/api": {
        target: "http://127.0.0.1:8000",
        changeOrigin: true,
      },
      "/storage": {
        target: "http://127.0.0.1:8000",
        changeOrigin: true,
      },
    },
  },
});
