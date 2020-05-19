// token create
var rand = function() {
    return Math.random().toString(36).substr(2); // remove `0.`
};

var token = function() {
    return rand() + rand(); // to make it longer
};

var token = token(); // "bnh5yzdirjinqaorq0ox1tf383nb3xr"


// check for error in input fields
function checkError() {
    const fields = document.querySelectorAll('input');
    for (i = 0; i < fields.length; i++) {
        if (fields[i].classList.contains('is-invalid')) {
            return false;
        } else {
            return true;
        }
    }
}

// check password for input field
function checkPassword() {
    const field = document.getElementById('password');
    let value = field.value;
    if (value.length < 4) {
        field.classList.add('is-invalid');
    } else {
        field.classList.remove('is-invalid');
    }
}

// search function
function search() {

    let input = document.getElementById('search-input').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('card');


    for (i = 0; i < x.length; i++) {

        if (x[i].innerHTML.toLowerCase().includes(input)) {

            x[i].style.display = "block";

        } else {
            x[i].style.display = "none";
        }

    }
}

// navbar show hide function
function navbarShowHide() {
    const navList = document.getElementById('navbarNav');
    if (navList.style.display == 'block') {
        navList.style.display = 'none';
    } else {
        navList.style.display = 'block';
    }

}





// ENABLE/DISABLE HOUR&ITEM FIELDS AND ADD NEW FIELD ACCORDINGLY
function enable() {

    const text = document.getElementById('error-column');
    let select = document.getElementById('select');
    var itemField = document.getElementById('labour-charge');
    var hourField = document.getElementById('hour-charge');

    if (select.value === 'hour') {

        state = 'hour-charge';
        hourField.removeAttribute("readonly");
        itemField.setAttribute("readonly", true);

    } else if (select.value === 'item') {

        state = 'item-charge';
        itemField.removeAttribute("readonly");
        hourField.setAttribute("readonly", true);

    } else if (select.value === '0') {

        state = '';
        statechoose = 'Please choose "Charge Method"!';

    } else {

        state = '';
        statechoose = 'Please choose "Charge Method"!';

    }

    let addField = function() {

        function fields() {

            select.setAttribute('disabled', true);
            //part name input
            const partNameField = document.createElement('input');
            partNameField.type = 'text';
            partNameField.className = 'form-control mt-2 form-control-sm mr-sm-2 mt-2';
            partNameField.name = 'partname[]';
            partNameField.placeholder = 'Part Name';
            partNameField.required = true;
            const partNameCol = document.getElementById('part-name-column');
            partNameCol.appendChild(partNameField);

            //quantity input
            const quantityField = document.createElement('input');
            quantityField.type = 'number';
            quantityField.id = 'quantity';
            quantityField.className = 'form-control mt-2 form-control-sm mr-sm-2 mt-2';
            quantityField.name = 'quantity[]';
            quantityField.placeholder = 'Quantity';
            quantityField.required = true;
            const quantityCol = document.getElementById('quantity-column');
            quantityCol.appendChild(quantityField);

            //part price input
            const partPriceField = document.createElement('input');
            partPriceField.type = 'number';
            partPriceField.step = '0.01';
            partPriceField.id = 'item-price';
            partPriceField.className = 'form-control mt-2 form-control-sm mr-sm-2 mt-2';
            partPriceField.name = 'itemprice[]';
            partPriceField.placeholder = 'Part Price';
            partPriceField.required = true;
            const partPriceCol = document.getElementById('item-price-column');
            partPriceCol.appendChild(partPriceField);

        }


        if (state !== '' && state === 'hour-charge') {

            //labour charge input
            const labourPriceField = document.createElement('input');
            labourPriceField.type = 'number';
            labourPriceField.step = '0.01';
            labourPriceField.id = 'labour-charge';
            labourPriceField.className = 'form-control mt-2 form-control-sm mr-sm-2 mt-2';
            labourPriceField.name = 'labourcharge[]';
            labourPriceField.value = '0';
            labourPriceField.required = true;
            labourPriceField.setAttribute("readonly", true);
            const labourPriceCol = document.getElementById('labour-price-column');
            labourPriceCol.appendChild(labourPriceField);
            fields();
            statechoose = '';
            state = '';

        } else if (state !== '' && state === 'item-charge') {

            //labour charge input
            const labourPriceField = document.createElement('input');
            labourPriceField.type = 'number';
            labourPriceField.step = '0.01';
            labourPriceField.id = 'labour-charge';
            labourPriceField.className = 'form-control mt-2 form-control-sm mr-sm-2 mt-2';
            labourPriceField.name = 'labourcharge[]';
            labourPriceField.value = '0';
            labourPriceField.required = true;
            const labourPriceCol = document.getElementById('labour-price-column');
            labourPriceCol.appendChild(labourPriceField);
            fields();
            statechoose = '';
            state = '';

        }
        if (statechoose === '' && state === '') {

            text.textContent = '';

        }
        if (statechoose !== '' && state === '') {

            text.textContent = statechoose;

        }

    }


    return addField;


}


// add fields function ends here

// IMAGE FILE VALIDATION
function fileValidation() {
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    var img = fileInput.files[0].size;
    var imgSize = img / 1024 / 1024;
    var imgDec = imgSize.toFixed(2);

    const maxSize = 16;
    if (imgDec > maxSize) {
        alert(`Please upload files smaller than ${maxSize}Mib.\nYour file has ${imgDec}MiB`);
        fileInput.value = '';
        return false;
    }
    if (!allowedExtensions.exec(filePath)) {
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }

}

//fetch client and vehicle to file newjob.php

function getClient(string) {

    const iname = document.getElementById('client-name');
    const iaddress = document.getElementById('client-address');
    const iemail = document.getElementById('client-email');
    const icity = document.getElementById('client-city');
    const icountry = document.getElementById('client-country');
    const ipostcode = document.getElementById('client-postcode');
    const imob = document.getElementById('client-mob');
    const imobLand = document.getElementById('client-mob-landline');

    if (string !== '0') {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "../php/user/ajaxFetch.php?name=" + string, true);
        xhttp.send();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {

                let data = JSON.parse(this.responseText);

                for (i = 0; i < data.length; i++) {
                    let name = data[i].name;
                    let address = data[i].address;
                    let email = data[i].email;
                    let city = data[i].city;
                    let country = data[i].country;
                    let postcode = data[i].postcode;
                    let mob = data[i].mob_one;
                    let mobL = data[i].mob_two;

                    iname.value = name;
                    iaddress.value = address;
                    iemail.value = email;
                    icity.value = city;
                    icountry.value = country;
                    ipostcode.value = postcode;
                    imob.value = mob;
                    imobLand.value = mobL;
                }
            }
        }
    } else {
        iname.value = '';
        iaddress.value = '';
        iemail.value = '';
        icity.value = '';
        icountry.value = '';
        ipostcode.value = '';
        imob.value = '';
        imobLand.value = '';
    }

}


function getVehicle(string) {

    const ireg = document.getElementById('reg');
    const imake = document.getElementById('make');
    const imodel = document.getElementById('model');
    const ivin = document.getElementById('vin');
    const iodometer = document.getElementById('odometer');
    const ifuel = document.getElementById('fuel');

    if (string !== '0') {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "../php/user/ajaxFetch.php?reg=" + string, true);
        xhttp.send();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {

                let data = JSON.parse(this.responseText);

                for (i = 0; i < data.length; i++) {
                    let reg = data[i].reg;
                    let make = data[i].make;
                    let model = data[i].model;
                    let vin = data[i].vin;
                    let odometer = data[i].odometer;
                    let fuel = data[i].fuel;

                    ireg.value = reg;
                    imake.value = make;
                    imodel.value = model;
                    ivin.value = vin;
                    iodometer.value = odometer;
                    ifuel.value = fuel;
                }
            }
        }
    } else {
        ireg.value = '';
        imake.value = '';
        imodel.value = '';
        ivin.value = '';
        iodometer.value = '';
        ifuel.value = '';
    }

}

//  back to previous page button
function goBack() {
    window.history.back();
}

// login
function checkUserName(string) {

    const input = document.getElementById('username');
    if (string != '') {
        let http = new XMLHttpRequest();
        http.open("POST", "../php/admin/fetch.php?username=" + string, true);
        http.send();

        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                if (data.length === 0) {
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            }
        }
    }

}







function spinner(status) {
    const parentDiv = document.getElementById('alert');
    if (status === 1) {
        const div = document.createElement('div');
        div.id = 'spinner';
        div.className = 'spinner-border text-success';
        div.style.position = 'fixed';
        div.style.top = '50%';
        div.style.left = '50%';
        div.style.zIndex = '10000';
        parentDiv.appendChild(div);
    }
    if (status === 0) {
        parentDiv.removeChild(parentDiv.childNodes[0]);
    }
}