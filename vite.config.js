import jigsaw from "@tighten/jigsaw-vite-plugin";
import { defineConfig } from "vite";
import fs from "fs";
import os from "os";
import path from "path";

const host = "leuver.ink.test";
const certPath = path.resolve(
  os.homedir(),
  "Library/Application Support/Herd/config/valet/Certificates"
);

export default defineConfig({
  server: {
    host,
    hmr: { host },
    https: {
      key: fs.readFileSync(path.resolve(certPath, `${host}.key`)),
      cert: fs.readFileSync(path.resolve(certPath, `${host}.crt`)),
    },
  },
  plugins: [
    jigsaw({
      input: [
        "source/_assets/js/app.js",
        "source/_assets/css/app.css",
        "source/_assets/css/font.css",
      ],
      refresh: true,
      buildDirectory: "assets/build",
    }),
  ],
});
