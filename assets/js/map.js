let mapEdit = document.getElementById("map-edit"),
    mapNew = document.getElementById("map-new"),
    mapPopup = document.getElementById("map-popup"),
    displayed = false;

if (mapEdit) {
    mapEdit.addEventListener('click', displayMapForm);
    mapNew.addEventListener('click', addNewPin);

    document.addEventListener('click', function (e) {
        if (displayed) {
            let testForm = e.target.closest("#map-popup > form");

            if(!testForm){
                hideMapForm();
            }
        }
    })

    document.addEventListener('keydown', function (e) {
        if (displayed && e.key === 'Escape') {
            hideMapForm();
        }
    })
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
                        console.log(json)
                    });
            } else {
                response.json()
                    .then(response => console.log(response));
            }
        });
}