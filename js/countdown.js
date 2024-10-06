function initializeCountdown(id) {
    const countdownElement = document.getElementById(id);
    const endDate = countdownElement.getAttribute('data-date');
    const endDateTime = new Date(endDate).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = endDateTime - now;

        if (timeLeft < 0) {
            countdownElement.innerHTML = "Time's up!";
            return;
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        countdownElement.querySelector('.days').innerHTML = days;
        countdownElement.querySelector('.hours').innerHTML = hours;
        countdownElement.querySelector('.minutes').innerHTML = minutes;
        countdownElement.querySelector('.seconds').innerHTML = seconds;
    }

    setInterval(updateCountdown, 1000);
}
