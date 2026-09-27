import axios from "axios";
import moment from "moment";
import "flowbite";
import './echo';
import "./pagination";
import "./alpine";
import ServerRequest from "./request";


window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.DatePicker = Datepicker;
window.moment = moment;
window.ServerRequest = ServerRequest;

window.submitResourceDeleteForm = (formId) => {
    const form = document.querySelector(`form#${formId}`);
    form.submit();
};

window.setInputValue = (inputId) => {
    console.log('Time has been set for input with ID: ' + inputId);
    const input = document.getElementById(inputId);
    input.value = moment().format('DD-MM-Y H:mm');
};

