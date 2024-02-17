import "./bootstrap";

import Alpine from "alpinejs";

import.meta.glob(["../images/**", "../fonts/**", "../mp3/**"]);

window.Alpine = Alpine;

Alpine.start();
