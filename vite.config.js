import jigsaw from "@tighten/jigsaw-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
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
