let inputs = document.querySelectorAll(".api-form input, .api-form select, .api-form textarea"),
    forms = document.querySelectorAll('form.api-form'),
    timeout;

for (let input of inputs) {
    input.addEventListener('keydown', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            sendForm(input.form);
        }, 100);
    });
    input.addEventListener('change', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            sendForm(input.form);
        }, 100);
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
    }, 1000)
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
        button.addEventListener("click", function () {
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

                if (percent > 100) {
                    percent = 100;
                }

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
                }, 100);
            }
        });
    }
}

let newCategoryBtn = document.getElementById("newCategoryBtn");
let newCategoryInput = document.getElementById("newCategory");

if (newCategoryBtn) {
    newCategoryBtn.addEventListener('click', newCategory);
    newCategoryInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') {
            newCategory();
        }
    })
}

function newCategory () {
    let value = newCategoryInput.value;
    if (value.length > 0) {
        fetch('/api/category/create/' + value)
            .then(function (response) {
                if (response.status === 200) {
                    response.json()
                        .then(function (json) {
                            let category = JSON.parse(json);
                            let html = `
                                    <div class="col col-6 category" data-id="` + category.id + `">
                                        <div class="border border-darker rounded">
                                            <div class="input-group d-flex justify-content-between">
                                                <input class="form-control border-0 categoryName" style="font-size: 24px" value="` + category.name + `">
                                                <button class="btn btn-dark rounded-0 deleteCategoryBtn" style="max-width: 55px;"><i class="bi-trash"></i></button>
                                            </div>
                                            <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center input-group bg-transparent border-darker p-0 rounded-0 border-bottom-0 border-end-0 border-start-0">
                                                    <input class="form-control border-0 newItem" id="newItem" placeholder="Nouvel objet" aria-label="Nouvel objet">
                                                    <div class="input-group-append ">
                                                        <button class="btn btn-dark rounded-0 newItemBtn" type="button">Ajouter</button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                `
                            let elem = fromHTML(html);
                            document.getElementById("categories").insertBefore(elem, document.getElementById("lastCategory"));
                            newCategoryInput.value = "";
                        });
                } else {
                    response.json()
                        .then(response => console.log(response));
                }
            });
    }
}

document.addEventListener("click", function(e){
    let deleteCategoryBtn = e.target.closest(".deleteCategoryBtn");
    let addItemBtn = e.target.closest(".newItemBtn");
    let deleteItemBtn = e.target.closest(".deleteItemBtn");
    let increaseCountBtn = e.target.closest(".addQuantity");
    let decreaseCountBtn = e.target.closest(".removeQuantity");

    if(deleteCategoryBtn){
        deleteCategory(deleteCategoryBtn.parentElement.parentElement.parentElement);
    }
    else if (addItemBtn) {
        newItem(addItemBtn.parentElement.previousElementSibling);
    }
    else if (deleteItemBtn) {
        deleteItem(deleteItemBtn.parentElement);
    }
    else if (increaseCountBtn) {
        changeCount(1, increaseCountBtn);
    }
    else if (decreaseCountBtn) {
        changeCount(-1, decreaseCountBtn);
    }
});

document.addEventListener("keydown", function(e){
    let categoryNameInput = e.target.closest(".categoryName");
    let itemNameInput = e.target.closest(".itemName");
    let itemCountInput = e.target.closest(".itemCount");
    let newItemInput = e.target.closest(".newItem");

    if(categoryNameInput){
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            updateCategory(categoryNameInput);
        }, 100);
    }
    else if (newItemInput && e.key === 'Enter') {
        newItem(newItemInput);
    }
    else if(itemNameInput){
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            updateItem(itemNameInput.parentElement);
        }, 100);
    }
    else if(itemCountInput){
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            updateItem(itemCountInput.parentElement);
        }, 100);
    }
});

function deleteCategory(categoryElem) {
    fetch('/api/category/delete/' + categoryElem.dataset.id)
        .then(function (response) {
            if (response.status === 200) {
                categoryElem.remove()
            } else {
                response.json()
                    .then(response => console.log(response));
            }
        });
}

function updateCategory(categoryNameInput) {
    if (categoryNameInput.value.length > 0) {
        fetch('/api/category/update/' + categoryNameInput.parentElement.parentElement.parentElement.dataset.id + '/' + categoryNameInput.value)
            .then(function (response) {
                if (response.status === 200) {
                    validate();
                } else {
                    response.json()
                        .then(response => console.log(response));
                }
            });
    }
}

function fromHTML(html, trim = true) {
    // Process the HTML string.
    html = trim ? html.trim() : html;
    if (!html) return null;

    // Then set up a new template element.
    const template = document.createElement('template');
    template.innerHTML = html;
    const result = template.content.children;

    // Then return either an HTMLElement or HTMLCollection,
    // based on whether the input HTML had one or more roots.
    if (result.length === 1) return result[0];
    return result;
}

function newItem (newItemInput) {
    let value = newItemInput.value;
    if (value.length > 0) {
        fetch('/api/item/create/' + value + '/' + newItemInput.parentElement.parentElement.parentElement.parentElement.dataset.id)
            .then(function (response) {
                if (response.status === 200) {
                    response.json()
                        .then(function (json) {
                            let item = JSON.parse(json);
                            let html = `
                                    <li class="list-group-item d-flex justify-content-between align-items-center input-group bg-transparent border-darker item p-0 rounded-0 border-start-0 border-end-0" data-id="` + item.id + `">
                                        <input class="form-control border-0 itemName" value="` + item.name + `">
                                        <button class="input-group-text border-0 bg-dark text-light removeQuantity">-</button>
                                        <input class="form-control border-0 itemCount" value="1" type="text" style="max-width: 55px;">
                                        <button class="input-group-text border-0 bg-dark text-light addQuantity">+</button>
                                        <button class="input-group-text border-0 bg-danger text-light rounded-0 deleteItemBtn"><i class="bi-trash"></i></button>
                                    </li>
                                `
                            let elem = fromHTML(html);
                            newItemInput.parentElement.parentElement.insertBefore(elem, newItemInput.parentElement);
                            newItemInput.value = "";
                        });
                } else {
                    response.json()
                        .then(response => console.log(response));
                }
            });
    }
}

function deleteItem(itemElem) {
    fetch('/api/item/delete/' + itemElem.dataset.id)
        .then(function (response) {
            if (response.status === 200) {
                itemElem.remove()
            } else {
                response.json()
                    .then(response => console.log(response));
            }
        });
}

function updateItem(itemElem) {
    let itemNameInput = itemElem.querySelector('.itemName');
    let itemCountInput = itemElem.querySelector('.itemCount');
    if (itemNameInput.value.length > 0) {
        fetch('/api/item/update/' + itemElem.dataset.id + '/' + itemNameInput.value + '/' + itemCountInput.value)
            .then(function (response) {
                if (response.status === 200) {
                    validate();
                } else {
                    response.json()
                        .then(response => console.log(response));
                }
            });
    }
}

function changeCount(amount, button) {
    let input = button.parentElement.querySelector('.itemCount');
    input.value = parseInt(input.value) + amount;
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        updateItem(button.parentElement);
    }, 100);
}