import DiceBox from '@3d-dice/dice-box';
let diceBox;
let diceTimeout;

if (document.getElementById('dice-box')) {
    diceBox = new DiceBox("#dice-box", {
        assetPath: "/assets/",
        scale: 6,
        theme: "smooth",
        gravity: 4
    });

    diceBox.init();

    document.getElementById('dice-btn').addEventListener('click', startDice);
}

function startDice () {
    clearTimeout(diceTimeout);
    document.getElementById('dice-result').innerHTML = '';
    document.getElementById('dices').style.opacity = 1;
    document.getElementById("dice-result").style.color = 'unset';
    diceBox.roll(['1d100', '1d10']).then((results) => {
        let total = 0;
        for (let result of results) {
            total += result.value;
        }
        if (total === 0) {
            total = 100
        }
        if (total <= 5) {
            coupCritique();
        }
        else if (total >= 96) {
            echecCritique();
        }

        console.log(total);
        document.getElementById("dice-result").innerHTML = total;
        diceTimeout = setTimeout(function() {
            document.getElementById('dices').style.opacity = 0;
        }, 3000)
    });
}

function coupCritique () {
    document.getElementById("dice-result").style.color = 'green';
}

function echecCritique () {
    document.getElementById("dice-result").style.color = 'red';
}