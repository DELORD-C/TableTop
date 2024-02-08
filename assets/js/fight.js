import Sortable from 'sortablejs';
document.addEventListener('DOMContentLoaded', function () {
   let fightBtns= document.querySelectorAll(".fight-toggle");
   let playBtns = document.querySelectorAll(".fight-play");

   for (let fightBtn of fightBtns) {
       fightBtn.addEventListener('click', function () {
           toggleFight(fightBtn.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement);
       })
   }

    for (let playBtn of playBtns) {
        playBtn.addEventListener('click', function () {
            play(playBtn.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement);
        })
    }

    document.querySelector(".next-turn").addEventListener("click", nextTurn);
    document.querySelector(".sort-btn").addEventListener("click", sortTimeline);

    //Init sortableJs
    let timeline = document.getElementById("timeline");
    Sortable.create(timeline, {
        group: {
            name: 'timeline',
            pull: true,
            sort: true,
            direction: 'horizontal'
        },
        animation: 100
    });

    sortTimeline();
});

function toggleFight(entityCard) {
    fetch('/api/switchFighting/' + entityCard.getAttribute('type') + '/' + entityCard.getAttribute('id'))
        .then(function (response) {
            if (response.status !== 200) {
                console.log(response);
            }
            else {
                response.json().then(function(rep) {
                    if (rep === true) {
                        moveToTimeline(entityCard);
                    }
                    else {
                        removeFromTimeline(entityCard);
                    }
                })
            }
        });
}

function moveToTimeline(entityCard) {
    document.querySelector(".fight-container > .entity-list").appendChild(entityCard);
    entityCard.querySelector(".fight-toggle i").classList.remove("bi-arrow-90deg-down");
    entityCard.querySelector(".fight-toggle i").classList.add("bi-arrow-90deg-up");
}

function removeFromTimeline(entityCard) {
    if (entityCard.getAttribute('type') === 'pnj') {
        document.querySelector(".pnj-container > .entity-list").appendChild(entityCard);
    }
    else {
        document.querySelector(".player-container > .entity-list").appendChild(entityCard);
    }
    entityCard.classList.remove("playing");
    entityCard.querySelector(".fight-toggle i").classList.remove("bi-arrow-90deg-up");
    entityCard.querySelector(".fight-toggle i").classList.add("bi-arrow-90deg-down");
}

function play(entityCard) {
    fetch('/api/switchPlaying/' + entityCard.getAttribute('type') + '/' + entityCard.getAttribute('id'))
        .then(function (response) {
            if (response.status !== 200) {
                response.text().then(function (e) {
                    console.log(e);
                })
            }
            else {
                response.json().then(function (rep) {
                    if (rep === true) {
                        let playing = document.querySelector(".playing");
                        if (playing) {
                            document.querySelector(".playing").classList.remove("playing");
                        }
                        entityCard.classList.add("playing");
                    }
                })
            }
        });
}

function nextTurn() {
    if (
        document.querySelectorAll(".fight-container > .entity-list > div")
        && document.querySelectorAll(".fight-container > .entity-list > div").length > 0
    ) {
        let current = document.querySelector(".playing");
        if (current) {
            if (current.nextElementSibling) {
                play(current.nextElementSibling);
            }
            else {
                play(document.querySelector(".fight-container > .entity-list").firstElementChild);
            }
        }
        else {
            play(document.querySelector(".fight-container > .entity-list").firstElementChild);
        }
    }
}

function sortTimeline() {
    let entities = document.querySelectorAll(".fight-container > .entity-list > div");
    for (let entity of entities) {
        while (
            entity.previousElementSibling && (
                entity.dataset.speed > entity.previousElementSibling.dataset.speed ||
                (
                    entity.getAttribute('type') === entity.previousElementSibling.getAttribute('type') &&
                    entity.dataset.speed === entity.previousElementSibling.dataset.speed &&
                    parseInt(entity.getAttribute('id')) < parseInt(entity.previousElementSibling.getAttribute('id'))
                ) ||
                (
                    entity.dataset.speed === entity.previousElementSibling.dataset.speed &&
                    entity.getAttribute('type') === 'player' &&
                    entity.previousElementSibling.getAttribute('type') === 'pnj'
                )
            )
        ) {
            entity.after(entity.previousElementSibling);
        }
    }
}