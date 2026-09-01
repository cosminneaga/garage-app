import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.store("notification", {
        list_show: false,
        indicator_show: false,
        data: [],

        showList() {
            this.list_show = true;
        },
        hideList() {
            this.list_show = false;
        },
        showIndicator() {
            this.indicator_show = true;
        },
        hideIndicator() {
            this.indicator_show = false;
        },
    });
});

Alpine.start();
