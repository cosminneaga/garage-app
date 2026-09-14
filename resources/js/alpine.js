import Alpine from "alpinejs";

window.Alpine = Alpine;

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

Alpine.store("form_data", {
    company: null,
    car: {
        make_id: null,
        model_id: null,
        data_id: null,
    },

    setCompany(company) {
        this.company = company;
    },
    getCompany() {
        return this.company;
    },
});

Alpine.start();
