import jigsaw from "@tighten/jigsaw-vite-plugin";
import { defineConfig } from "vite";
import fs from "fs";
import os from "os";
import path from "path";

const host = "leuver.ink.test";

// Serve dev assets over https using Herd's certificate, so the
// https page doesn't block them as mixed content. Certs only
// exist on the local machine, not on CI.
const key = path.resolve(
  os.homedir(),
  `Library/Application Support/Herd/config/valet/Certificates/${host}.key`
);
const cert = path.resolve(
  os.homedir(),
  `Library/Application Support/Herd/config/valet/Certificates/${host}.crt`
);

export default defineConfig({
  server:
    fs.existsSync(key) && fs.existsSync(cert)
      ? {
          host,
          hmr: { host },
          https: {
            key: fs.readFileSync(key),
            cert: fs.readFileSync(cert),
          },
        }
      : {},
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
