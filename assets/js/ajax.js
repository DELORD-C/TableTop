let inputs = document.querySelectorAll(".api-form input, .api-form select, .api-form textarea"),
    forms = document.querySelectorAll('form.api-form'),
    timeout;
let notify = document.getElementById("notify");

for (let input of inputs) {
    input.addEventListener('keydown', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            sendForm(input.form);
        }, 500);
    });
    input.addEventListener('change', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            sendForm(input.form);
        }, 500);
    });
}

function sendForm (form) {
    fetch(form.action, { method: form.method, body: new FormData(form) })
        .then(function (response) {
            if (response.status !== 200) {
                console.log(response);
                fail();
            }
            else {
                validate();
            }
        });
}

function validate () {
    console.log('ok');
    document.getElementById('validate').style.opacity = "1";
    document.getElementById('validate').style.fontSize = "40px";
    setTimeout(function() {
        document.getElementById('validate').style.opacity = "0";
        setTimeout(function() {
            document.getElementById('validate').style.transition = "none";
            document.getElementById('validate').style.fontSize = "20px";
            document.getElementById('validate').style.transition = "0.3s";

        }, 400)
    }, 2000)
}

function fail () {
    document.getElementById('fail').style.opacity = "1";
    document.getElementById('fail').style.fontSize = "40px";
    setTimeout(function() {
        document.getElementById('fail').style.opacity = "0";
        setTimeout(function() {
            document.getElementById('fail').style.transition = "none";
            document.getElementById('fail').style.fontSize = "20px";
            document.getElementById('fail').style.transition = "0.3s";

        }, 400)
    }, 2000)
}

if (forms.length > 0) {
    setInterval(function () {
        for (let form of forms) {
            let updatePath = form.getAttribute('update');
            if (updatePath) {
                fetch('/api/' + updatePath)
                    .then(function (response) {
                        if (response.status === 200) {
                            response.json()
                                .then(response => updateFormInputs(form, response));
                        }
                        else {
                            response.json()
                                .then(response => console.log(response));
                        }
                    });
            }
        }
    }, 5000)
}

function updateFormInputs(form, data) {
    let elements = form.querySelectorAll("input:not([type='hidden']), select, textarea");
    for (let element of elements) {
        if (element !== document.activeElement) {
            let ids = element.getAttribute('id').split('_');
            let attribute = ids[ids.length - 1]
            if (attribute === 'token') {
                element.value = data['token']['id']
            }
            else {
                element.value = data[attribute];
            }
        }
    }
}

let pnjSearch = document.getElementById("pnj-search");

if (pnjSearch) {
    pnjSearch.addEventListener("change", filterPnjs);
    pnjSearch.addEventListener("keydown", filterPnjs);
}

function filterPnjs () {
    for (let pnj of document.getElementsByClassName("pnj-card")) {
        if (pnj.querySelector('h6').innerHTML.toLowerCase().includes(pnjSearch.value.toLowerCase()) || pnjSearch.value === '') {
            pnj.classList.remove('hidden');
        }
        else {
            pnj.classList.add('hidden');
        }
    }
}

let updateButtons = document.querySelectorAll(".updatable-object button"),
    updateTimeout,
    value = 0;

if (updateButtons.length > 0) {
    for (let button of updateButtons) {
        button.addEventListener("click", function (e) {
            clearTimeout(updateTimeout);
            let container = this.parentElement,
                btn = this,
                op,
                max = parseInt(container.getAttribute('max')),
                span = container.querySelector('span'),
                actual = parseInt(span.innerHTML);

            if (btn.innerHTML === '+') {
                op = 1;
            } else {
                op = -1;
            }

            if (actual < max || (actual === max && op === -1)) {
                value = value + op;

                let percent = 100 - Math.round((actual + op) * 100 / max);

                container.querySelector('.mask').style.height = percent + '%';

                span.innerHTML = (actual + op).toString();

                updateTimeout = setTimeout(function () {
                    fetch('/api/updateEntityStat/' + container.getAttribute('type') + '/' + container.getAttribute('stat') + '/' + container.getAttribute('id') + '/' + value)
                        .then(function (response) {
                            if (response.status === 200) {
                                response.json()
                                    .then(function (response) {
                                        span.innerHTML = response
                                        clearTimeout(updateTimeout)
                                    });
                            } else {
                                response.json()
                                    .then(response => console.log(response));
                            }
                        });
                    value = 0;
                }, 500);
            }
        });
    }
}