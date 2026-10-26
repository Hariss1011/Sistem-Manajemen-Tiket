import "./bootstrap";

import Alpine from "alpinejs";
import checkout from "./checkout";

window.Alpine = Alpine;

Alpine.data("checkout", checkout);

Alpine.start();
