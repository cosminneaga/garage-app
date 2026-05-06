import axios from "axios";
import Alpine from "alpinejs";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Alpine = Alpine;
Alpine.start();

window.submitResourceDeleteForm = (formId) => {
    const form = document.querySelector(`form#${formId}`);
    form.submit();
};

window.openSendMessageModal = (name) => {
    showModal("send-message");
    domEl(".bw-send-message .modal-title").innerText =
        `Send Message to ${name}`;
};
