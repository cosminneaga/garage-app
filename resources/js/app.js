import axios from "axios";
import "flowbite";
import './echo';
import "./pagination";
import "./alpine";
import moment from "moment";


window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.DatePicker = Datepicker;
window.moment = moment;

window.submitResourceDeleteForm = (formId) => {
    const form = document.querySelector(`form#${formId}`);
    form.submit();
};

window.setInputValue = (inputId) => {
    console.log('Time has been set for input with ID: ' + inputId);
    const input = document.getElementById(inputId);
    input.value = moment().format('DD-MM-Y H:mm');
};

