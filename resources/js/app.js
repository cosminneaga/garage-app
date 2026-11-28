import axios from "axios";
import moment from "moment";
import "flowbite";
import './echo';
import "./pagination";
import Alpine from "alpinejs";
import ServerRequest from "./request";
import Dropzone from "dropzone";


window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.DatePicker = Datepicker;
window.ServerRequest = ServerRequest;
window.moment = moment;
window.Dropzone = Dropzone;
window.Alpine = Alpine;

window.submitResourceDeleteForm = (formId) => {
    const form = document.querySelector(`form#${formId}`);
    form.submit();
};

window.setInputValue = (inputId) => {
    console.log('Time has been set for input with ID: ' + inputId);
    const input = document.getElementById(inputId);
    input.value = moment().format('DD-MM-Y H:mm');
};

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

Alpine.start();
