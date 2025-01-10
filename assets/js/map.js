let mapEdit, mapNew, mapPopup, pinPopup, displayed, pins, mapBg, xOffset, yOffset, currentPin;

document.addEventListener('DOMContentLoaded', function () {
    initMap();
});

document.addEventListener('turbo:render', function () {
    initMap();
});
function initMap () {
    mapEdit = document.getElementById("map-edit");
    mapNew = document.getElementById("map-new");
    mapPopup = document.getElementById("map-popup");
    pinPopup = document.getElementById("pin-popup");
    pins = document.getElementsByClassName('map-pin');
    mapBg = document.getElementById('map-bg');

    if (mapBg) {
        mapEdit.addEventListener('click', displayMapForm);
        mapNew.addEventListener('click', addNewPin);

        mapPopup.addEventListener('click', function (e) {
                if(e.target === mapPopup) {
                    hideMapForm();
                }
        })

        mapBg.addEventListener('dragover', function (e) {
            xOffset = (e.offsetX - 13) / mapBg.offsetWidth * 100;
            yOffset = (e.offsetY - 22) / mapBg.offsetHeight * 100;
        })

        for (let pin of pins) {
            pin.addEventListener('dragstart', function () {
                pin.style.opacity = 0;
                setTimeout(function () {
                    pin.style.transition = "0s";
                }, 300)
            });

            pin.addEventListener('dragend', function () {
                pin.style.left = xOffset + "%";
                pin.style.top = yOffset + "%";
                saveNewPosition(pin);
                pin.style.opacity = 1;
                setTimeout(function () {
                    pin.style.transition = "0.3s";
                }, 300)
            })

            pin.addEventListener('click', function() {
                displayPinForm(pin);
                currentPin = pin;
            })

            document.getElementById("pin_name").addEventListener("change", function () {
                currentPin.dataset.name = this.value;
            })

            document.getElementById("pin_color").addEventListener("change", function () {
                currentPin.style.color = this.value;
            })

            document.getElementById("pin-delete").addEventListener("click", function () {
                fetch('/api/pin/delete/' + currentPin.dataset.id)
                    .then(function (response) {
                        if (response.status === 200) {
                            currentPin.remove();
                        } else {
                            response.json()
                                .then(response => console.log(response));
                        }
                    });
                hidePinForm();
            })

            pinPopup.addEventListener('click', function (e) {
                if (e.target === pinPopup) {
                    hidePinForm();
                }
            })

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    hidePinForm();
                    hideMapForm();
                }
            })
        }
    }
}

function saveNewPosition (pin) {
    fetch('/api/pin/updatePosition/' + pin.dataset.id + '/' + xOffset + '/' + yOffset)
        .then(function (response) {
            if (response.status !== 200) {
                response.json()
                    .then(response => console.log(response));
            }
        });
}

function displayPinForm (pin) {
    pinPopup.style.opacity = '1';
    pinPopup.style.pointerEvents = 'all';
    document.querySelector("#pin-popup > form").dataset.id = pin.dataset.id;
    document.querySelector("#pin-popup > form").setAttribute('action', "/api/pin/update/" + pin.dataset.id);
    document.getElementById("pin_name").value = pin.dataset.name;
    document.getElementById("pin_note").value = pin.dataset.note;
    document.getElementById("pin_color").value = pin.style.color;
}

function hidePinForm () {
    pinPopup.style.opacity = '0';
    pinPopup.style.pointerEvents = 'none';
}

function displayMapForm () {
    if (!displayed) {
        mapPopup.style.display = 'flex';
        setTimeout(function () {
            displayed = true;
        }, 200)
    }
}

function hideMapForm () {
    if (displayed) {
        mapPopup.style.display = 'none';
        setTimeout(function () {
            displayed = false;
        }, 200)
    }
}

function addNewPin () {
    fetch('/api/pin/new/')
        .then(function (response) {
            if (response.status === 200) {
                response.json()
                    .then(function (json) {
                        let newPin = JSON.parse(json);
                        console.log(newPin);
                        let pinElem = document.createElement('i');
                        pinElem.classList.add("bi", "bi-geo-alt-fill", "map-pin");
                        pinElem.draggable = true;
                        pinElem.id = "pin" + newPin.id;
                        pinElem.style.left = newPin.x + "%";
                        pinElem.style.top = newPin.y + "%";
                        pinElem.dataset.id = newPin.id;
                        pinElem.dataset.name = "";
                        pinElem.dataset.note = "";
                        document.getElementById("map-bg").before(pinElem);
                        pinElem.addEventListener('dragstart', function () {
                            pinElem.style.opacity = 0;
                            setTimeout(function () {
                                pinElem.style.transition = "0s";
                            }, 300)
                        });

                        pinElem.addEventListener('dragend', function () {
                            pinElem.style.left = xOffset + "%";
                            pinElem.style.top = yOffset + "%";
                            saveNewPosition(pinElem);
                            pinElem.style.opacity = 1;
                            setTimeout(function () {
                                pinElem.style.transition = "0.3s";
                            }, 300)
                        })
                        pinElem.addEventListener('click', function() {
                            displayPinForm(pinElem);
                            currentPin = pinElem;
                        })
                    });
            } else {
                response.json()
                    .then(response => console.log(response));
            }
        });
}