import DiceBox from '@3d-dice/dice-box';
let diceBox;
let diceTimeout;

if (document.getElementById('dice-box')) {
    diceBox = new DiceBox("#dice-box", {
        assetPath: "/assets/",
        scale: 6,
        theme: "rock",
        gravity: 4
    });

    diceBox.init();

    document.getElementById('dice-btn-2').addEventListener('click', () => { rollDice('1d2') });
    document.getElementById('dice-btn-3').addEventListener('click', () => { rollDice('1d3') });
    document.getElementById('dice-btn-4').addEventListener('click', () => { rollDice('1d4') });
    document.getElementById('dice-btn-6').addEventListener('click', () => { rollDice('1d6') });
    document.getElementById('dice-btn-10').addEventListener('click', () => { rollDice('1d10') });
    document.getElementById('dice-btn-20').addEventListener('click', () => { rollDice('1d20') });
    document.getElementById('dice-btn-100').addEventListener('click', () => { rollDice('1d100') });
}

function rollDice (dice) {
    clearTimeout(diceTimeout);
    document.getElementById('dices').style.opacity = 1;
    document.getElementById('dice-result').innerHTML = '';
    document.getElementById("dice-result").style.color = 'unset';

    let audio = new Audio(diceSound);
    audio.play();

    diceBox.roll([dice]).then((results) => {
        let total = 0;
        for (let result of results) {
            total += result.value;
        }
        if (dice === '1d100') {
            if (total === 0) {
                total = 100
            }
            if (total <= 5) {
                coupCritique();
            }
            else if (total >= 96) {
                echecCritique();
            }
        }

        document.getElementById("dice-result").innerHTML = total;
        diceTimeout = setTimeout(function() {
            document.getElementById('dices').style.opacity = '0';
        }, 3000)
    });
}

function coupCritique () {
    document.getElementById("dice-result").style.color = 'green';
}

function echecCritique () {
    document.getElementById("dice-result").style.color = 'red';
}