import axios from "axios";
import "flowbite";
import './echo';
import "./pagination";
import "./alpine";


window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.submitResourceDeleteForm = (formId) => {
    const form = document.querySelector(`form#${formId}`);
    form.submit();
};


