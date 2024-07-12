<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Nilai</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .base-timer {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .base-timer__svg {
            transform: scaleX(-1);
        }

        .base-timer__circle {
            fill: none;
            stroke: none;
        }

        .base-timer__path-elapsed {
            stroke-width: 7px;
            stroke: grey;
        }

        .base-timer__path-remaining {
            stroke-width: 7px;
            stroke-linecap: round;
            transform: rotate(90deg);
            transform-origin: center;
            transition: 1s linear all;
            fill-rule: nonzero;
            stroke: currentColor;
        }

        .base-timer__path-remaining.green {
            color: rgb(65, 184, 131);
        }

        .base-timer__path-remaining.orange {
            color: orange;
        }

        .base-timer__path-remaining.red {
            color: red;
        }

        .base-timer__label {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }

        #header {
            position: relative;
        }

        #logo {
            position: absolute;
            top: 1rem;
            right: 0;
        }
    </style>
</head>

<body>
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-slate-100 py-6 sm:py-12">
        <div class="min-h-28 ">

            <div id="header" class="max-w-screen-lg mx-auto py-4">
                <div id="timer" class="w-32 h-32 bg-blue-100 absolute">

                </div>

                <h2 class="font-bold text-center text-4xl text-slate-700 font-display">
                    LOMBA CERDAS CERMAT
                </h2>
                <p class="text-center mt-4 font-medium text-3xl text-slate-500">KELOMPOK INFORMASI MASYARAKAT</p>
                <p class="text-center mt-4 font-medium text-3xl text-slate-500">TINGKAT KECAMATAN SE-KOTA METRO TAHUN 2024</p>

                <div id="logo" style="width: 150px;">
                    <img src="logo.png" alt="">
                    <img src="logo-kim.png" alt="">
                </div>

                <div id="team-list" class="flex gap-6 mt-20">
                    <?php
                    $team_list = [
                        [
                            'id' => 1,
                            'nama' => 'METRO PUSAT',
                            'color' => 'red'
                        ],
                        [
                            'id' => 2,
                            'nama' => 'METRO UTARA',
                            'color' => 'blue'
                        ],
                        [
                            'id' => 3,
                            'nama' => 'METRO SELATAN',
                            'color' => 'yellow'
                        ],
                        [
                            'id' => 4,
                            'nama' => 'METRO BARAT',
                            'color' => 'emerald'
                        ],
                        [
                            'id' => 5,
                            'nama' => 'METRO TIMUR',
                            'color' => 'pink'
                        ],
                    ];
                    ?>

                    <?php foreach ($team_list as $team) { ?>
                        <div id="team-<?php echo $team['id']; ?>" data-team="<?php echo $team['id']; ?>" class="team bg-white w-1/5 shadow rounded-lg overflow-hidden">
                            <div class="bg-<?php echo $team['color']; ?>-500 p-6 text-center h-32 flex justify-center items-center">
                                <h1 class="font-bold text-3xl text-slate-100"><?php echo $team['nama']; ?></h1>
                            </div>
                            <div class="p-6">
                                <h2 class="mt-3 font-bold text-6xl pb-4 border-b border-slate-300 text-center score">0</h2>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var conn = new WebSocket('ws://localhost:8282');
        var client = {
            user_id: 1,
            recipient_id: null,
            type: 'socket',
            token: null,
            message: null
        };
        var snd = new Audio('ticking-timer-only.mp3');
        var sndStop = new Audio('stop-timer.mp3');
        var sndBenar = new Audio('benar.mp3');
        var sndSalah = new Audio('salah.mp3');

        $(document).ready(function() {
            refresh_score();
        });

        function refresh_score() {
            //load from localstorage
            for (var i = 1; i <= 5; i++) {
                if (localStorage.getItem('team-' + i)) {
                    $('#team-' + i).find('.score').text(localStorage.getItem('team-' + i));
                } else {
                    $('#team-' + i).find('.score').text(0);

                }
            }
        }

        sndBenar.addEventListener("ended", function() {
            sndBenar.currentTime = 0;
            Swal.close();
        });
        sndSalah.addEventListener("ended", function() {
            sndSalah.currentTime = 0;
            Swal.close();
        });

        function tambah_poin() {
            Swal.fire({
                icon: "success",
                showConfirmButton: false,
                timer: 2500
            });
            // sndBenar.play();
        }

        function kurang_poin() {
            Swal.fire({
                icon: "error",
                showConfirmButton: false,
                timer: 2500
            });
            // sndSalah.play();
        }

        function refresh_timer() {
            TIME_LIMIT = localStorage.getItem('timer') ?? 10;
            WARNING_THRESHOLD = localStorage.getItem('timer') ?? 10;
        }

        conn.onopen = function(e) {
            conn.send(JSON.stringify(client));
            $('#messages').append('<span color="green">Successfully connected as user ' + client.user_id + '</span><br>');
        };

        conn.onmessage = function(e) {
            var data = JSON.parse(e.data);
            // console.log(data);
            refresh_score();
            if (data.message) {
                // console.log('message', data.message);
                if (data.message.action !== undefined && data.message.action == 'set timer') {
                    localStorage.setItem('timer', data.message.timer);
                    refresh_timer();
                }
                if (data.message.action !== undefined && data.message.action == 'mulai timer') {
                    reset_timer();
                    startTimer();
                }
                if (data.message.action !== undefined && data.message.action == 'berhenti timer') {
                    stopTimer();
                }
                if (data.message.action !== undefined && data.message.action == 'tambah poin') {
                    tambah_poin();
                }
                if (data.message.action !== undefined && data.message.action == 'kurang poin') {
                    kurang_poin();
                }
                if (data.message.is_selected) {
                    $('#team-' + data.message.team_id).addClass('border-double border-4 border-indigo-600');
                    $('#team-' + data.message.team_id).siblings().removeClass('border-double border-4 border-indigo-600');
                    reset_timer();
                    startTimer();
                } else {
                    // reset_timer();
                }
                $('#messages').append(data.user_id + ' : ' + data.message + '<br>');
            }

        };

        function reset_timer() {
            timePassed = 0;
            timeLeft = TIME_LIMIT;
            remainingPathColor = COLOR_CODES.info.color;
            document.getElementById("base-timer-label").innerHTML = formatTime(
                timeLeft
            );

            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(COLOR_CODES.warning.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(COLOR_CODES.alert.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(COLOR_CODES.info.color);

            clearInterval(timerInterval);
            snd.pause();
            snd.currentTime = 0;
        }

        // Credit: Mateusz Rybczonec

        const FULL_DASH_ARRAY = 283;
        const ALERT_THRESHOLD = 5;
        let WARNING_THRESHOLD = localStorage.getItem('timer') ?? 10;

        const COLOR_CODES = {
            info: {
                color: "green"
            },
            warning: {
                color: "orange",
                threshold: WARNING_THRESHOLD
            },
            alert: {
                color: "red",
                threshold: ALERT_THRESHOLD
            }
        };

        let TIME_LIMIT = localStorage.getItem('timer') ?? 10;
        let timePassed = 0;
        let timeLeft = TIME_LIMIT;
        let timerInterval = null;
        let remainingPathColor = COLOR_CODES.info.color;

        document.getElementById("timer").innerHTML = `
        <div class="base-timer">
        <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <g class="base-timer__circle">
            <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
            <path
                id="base-timer-path-remaining"
                stroke-dasharray="283"
                class="base-timer__path-remaining ${remainingPathColor}"
                d="
                M 50, 50
                m -45, 0
                a 45,45 0 1,0 90,0
                a 45,45 0 1,0 -90,0
                "
            ></path>
            </g>
        </svg>
        <span id="base-timer-label" class="base-timer__label">${formatTime(
            timeLeft
        )}</span>
        </div>
        `;

        function onTimesUp() {
            clearInterval(timerInterval);
            snd.pause();
            snd.currentTime = 0;
            sndStop.play();
        }

        function startTimer() {
            snd.play();
            timerInterval = setInterval(() => {
                timePassed = timePassed += 1;
                timeLeft = TIME_LIMIT - timePassed;
                document.getElementById("base-timer-label").innerHTML = formatTime(
                    timeLeft
                );
                setCircleDasharray();
                setRemainingPathColor(timeLeft);

                if (timeLeft === 0) {
                    onTimesUp();
                }
            }, 1000);
        }

        function stopTimer() {
            clearInterval(timerInterval);
            snd.pause();
            snd.currentTime = 0;
        }

        function formatTime(time) {
            const minutes = Math.floor(time / 60);
            let seconds = time % 60;

            if (seconds < 10) {
                seconds = `0${seconds}`;
            }

            return `${minutes}:${seconds}`;
        }

        function setRemainingPathColor(timeLeft) {
            // console.log(timeLeft);
            const {
                alert,
                warning,
                info
            } = COLOR_CODES;
            if (timeLeft <= alert.threshold) {
                document
                    .getElementById("base-timer-path-remaining")
                    .classList.remove(warning.color);
                document
                    .getElementById("base-timer-path-remaining")
                    .classList.add(alert.color);
            } else if (timeLeft <= warning.threshold) {
                document
                    .getElementById("base-timer-path-remaining")
                    .classList.remove(info.color);
                document
                    .getElementById("base-timer-path-remaining")
                    .classList.add(warning.color);
            }
        }

        function calculateTimeFraction() {
            const rawTimeFraction = timeLeft / TIME_LIMIT;
            return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
        }

        function setCircleDasharray() {
            const circleDasharray = `${(
                calculateTimeFraction() * FULL_DASH_ARRAY
            ).toFixed(0)} 283`;
            document
                .getElementById("base-timer-path-remaining")
                .setAttribute("stroke-dasharray", circleDasharray);
        }
    </script>
</body>

</html>