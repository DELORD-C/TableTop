let playing,
    elapsed = 0,
    musicInterval,
    pause = false,
    playlists,
    ambiance,
    current = 0;

document.addEventListener('turbo:load', function () {
    initSoundEvents();
});

function updatePlaylists() {
    fetch('/api/playlists')
        .then(function (response) {
            if (response.status === 200) {
                response.json()
                    .then(function (json) {
                        playlists = json
                    });
            }
        });
}
updatePlaylists()

function initSoundEvents() {
    if (document.getElementById("ambiance-selector")) {
        if (ambiance && ambiance !== document.querySelector('#ambiance-selector > a.active').dataset.ambiance) {
            ambiance = document.querySelector('#ambiance-selector > a.active').dataset.ambiance
            updatePlaylists()
            current = 0
            if (playing) {
                if (playlists[ambiance][current]) {
                    playSound('/build/uploads/music/' + playlists[ambiance][current].file, true);
                }
            }
        }
        else if (!ambiance) {
            ambiance = document.querySelector('#ambiance-selector > a.active').dataset.ambiance
        }
    }

    let musicBtns = document.querySelectorAll('.music-play');
    for (let musicBtn of musicBtns) {
        musicBtn.addEventListener('click', function () {
            let file = musicBtn.dataset.file;
            playSound(file, true);
        });
    }

    let soundBtns = document.querySelectorAll('.sound-btn');
    for (let soundBtn of soundBtns) {
        soundBtn.addEventListener('click', function () {
            let file = "/build/uploads/sound/" + soundBtn.dataset.file;
            let sound = new Howl({
                src: [file],
                onend: function() {
                    if (playing) {
                        playing.fade(0.3, 0.7, 1000);
                    }
                }
            });
            if (playing) {
                playing.fade(0.7, 0.3, 200);
            }
            sound.play();
        });
    }

    if (document.getElementById('music-toggle')) {
        document.getElementById('music-toggle').addEventListener('click', function () {
            if (playing) {
                if (pause) {
                    playing.play();
                    document.querySelector('#music-toggle > i').classList.remove('bi-play');
                    document.querySelector('#music-toggle > i').classList.add('bi-pause');
                } else {
                    playing.pause();
                    document.querySelector('#music-toggle > i').classList.remove('bi-pause');
                    document.querySelector('#music-toggle > i').classList.add('bi-play');
                }
                pause = !pause;
            }
            else {
                if (playlists[ambiance][current]) {
                    playSound('/build/uploads/music/' + playlists[ambiance][current].file, true);
                }
            }
        });
    }

    if(document.getElementById('music-next')) {
        document.getElementById('music-next').addEventListener('click', function () {
            if (!playlists[ambiance][current + 1]) {
                current = 0
            }
            else {
                current++
            }
            if (playlists[ambiance][current]) {
                playSound('/build/uploads/music/' + playlists[ambiance][current].file, true);
            }
        });
    }

    if (playing && !pause) {
        document.querySelector('#music-toggle > i').classList.remove('bi-play');
        document.querySelector('#music-toggle > i').classList.add('bi-pause');
    }
}

function playSound(file, next = false) {
    let onend;

    if (playing) {
        playing.fade(0.7, 0, 5000);
    }

    if (next) {
        if (current === playlists[ambiance].length - 1) {
            updatePlaylists()
            onend = function () {
                current = 0
                playSound('/build/uploads/music/' + playlists[ambiance][0].file, next)
            }
        }
        else {
            onend = function () {
                current++
                playSound('/build/uploads/music/' + playlists[ambiance][current].file, next)
            }
        }
    }

    let music = new Howl({
        src: [file],
        onend: onend
    });

    music.play();
    document.querySelector('#music-toggle > i').classList.remove('bi-play');
    document.querySelector('#music-toggle > i').classList.add('bi-pause');
    document.querySelector('#music-title').innerHTML = file.replace('/build/uploads/music/', '');
    pause = false;
    elapsed = 0;
    music.fade(0, 0.7, 5000)

    let old = playing
    playing = music;
    setTimeout(function () {
        if (old) {
            old.stop();
        }
    }, 5000);

    return true;
}

musicInterval = setInterval(function () {
    if (playing && !pause && elapsed < playing.duration()) {
        elapsed += 1;
        let progress = elapsed / playing.duration() * 100;

        let minute = Math.floor(elapsed / 60);
        let second = Math.floor(elapsed) % 60;
        let formattedSecond = second < 10 ? '0' + second : second;
        document.getElementById('music-time').innerHTML = minute + ":" + formattedSecond;

        let durationMinute = Math.floor(playing.duration() / 60);
        let durationSecond = Math.floor(playing.duration()) % 60;
        let durationFormattedSecond = durationSecond < 10 ? '0' + durationSecond : durationSecond;
        document.getElementById('music-duration').innerHTML = durationMinute + ":" + durationFormattedSecond;

        document.getElementById('music-bar').style.width = progress + '%';

        document.querySelector('#music-title').innerHTML = playing._src.replace('/build/uploads/music/', '');
    }
}, 1000);