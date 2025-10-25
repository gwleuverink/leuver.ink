import "./store";

import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";

Alpine.plugin(intersect);
Alpine.plugin(persist);
Alpine.plugin(focus);

window.Alpine = Alpine;

Alpine.start();
