<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <form>
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Papan Nilai</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Manajemen papan nilai.</p>

                        <div class="mt-10">
                            <div class="md:col-2 sm:col-span-4">
                                <label for="waktu" class="block text-sm font-medium leading-6 text-gray-900">Waktu</label>
                                <div class="mt-2">
                                    <input id="waktu" name="waktu" type="number" autocomplete="waktu" class="block  rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6 h-20 text-4xl" value="10">

                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="set_timer" type="button">Set Timer</button>
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" id="mulai_timer" type="button">Mulai</button>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="berhenti_timer" type="button">Berhenti</button>
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <label for="poin_benar" class="block text-sm font-medium leading-6 text-gray-900">Poin Benar</label>
                                <div class="mt-2">
                                    <input id="poin_benar" name="poin_benar" type="number" autocomplete="poin_benar" class="block  rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6 h-20 text-4xl" value="100">
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <label for="poin_salah" class="block text-sm font-medium leading-6 text-gray-900">Poin Salah</label>
                                <div class="mt-2">
                                    <input id="poin_salah" name="poin_salah" type="number" autocomplete="poin_salah" class="block  rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6 h-20 text-4xl" value="100">
                                </div>
                            </div>
                            <div class="flex gap-6 mt-20">
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
                                    <div id="team-<?php echo $team['id'] ?>" data-team="<?php echo $team['id'] ?>" class="team bg-white w-1/5 shadow rounded-lg overflow-hidden">
                                        <div class="bg-<?php echo $team['color'] ?>-500 p-6 text-center h-32 flex justify-center items-center">
                                            <h1 class="font-bold text-3xl text-slate-100"><?php echo $team['nama'] ?></h1>
                                        </div>
                                        <div class="p-1">
                                            <h2 class="mt-3 font-bold text-6xl pb-4 border-b border-slate-300 text-center score">0</h2>

                                            <div class="flex mt-4 justify-center gap-2">
                                                <button type="button" class="btn-add text-base hover:scale-110 focus:outline-none flex justify-center px-2 py-2 rounded font-bold cursor-pointer  hover:bg-green-700 hover:text-green-100  bg-green-100  text-green-700  border duration-200 ease-in-out  border-green-600 transition">
                                                    <div class="flex leading-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    </div>
                                                </button>
                                                <button type="button" class="btn-minus text-base hover:scale-110 focus:outline-none flex justify-center px-2 py-2 rounded font-bold cursor-pointer  hover:bg-red-700 hover:text-red-100  bg-red-100  text-red-700  border duration-200 ease-in-out  border-red-600 transition">
                                                    <div class="flex leading-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var conn = new WebSocket('ws://localhost:8282');
        var client = {
            user_id: 2,
            recipient_id: null,
            type: 'socket',
            token: null,
            message: null
        };

        var message = {
            team_id: null,
            team_score: 0,
            team_score: false
        }

        $(document).ready(function() {
            refresh_score();
            refresh_timer();
        });

        function refresh_timer() {
            $('#waktu').val(localStorage.getItem('timer') ?? 10);
        }

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

        conn.onopen = function(e) {
            conn.send(JSON.stringify(client));
            $('#messages').append('<span color="green">Successfully connected as user ' + client.user_id + '</span><br>');
        };

        conn.onmessage = function(e) {
            var data = JSON.parse(e.data);
            if (data.message) {
                console.log('message', data.message);
                $('#messages').append(data.user_id + ' : ' + data.message + '<br>');
            }

        };

        $('#set_timer').click(function() {
            message.timer = $('#waktu').val();
            message.action = 'set timer';
            client.message = message;
            client.type = 'chat';
            client.recipient_id = "1";
            // console.log(JSON.stringify(client));
            conn.send(JSON.stringify(client));
        });

        $('#mulai_timer').click(function() {
            message.action = 'mulai timer';
            client.message = message;
            client.type = 'chat';
            client.recipient_id = "1";
            // console.log(JSON.stringify(client));
            conn.send(JSON.stringify(client));
        });
        $('#berhenti_timer').click(function() {
            message.action = 'berhenti timer';
            client.message = message;
            client.type = 'chat';
            client.recipient_id = "1";
            // console.log(JSON.stringify(client));
            conn.send(JSON.stringify(client));
        });

        $('.btn-add, .btn-minus, .btn-select').click(function() {
            // get team
            let team = $(this).closest('.team');
            let team_id = team.data('team');
            let team_score = team.find('.score').text();
            let is_selected = false;

            if ($(this).hasClass('btn-add')) {
                let poin = $('#poin_benar').val();
                team_score = parseInt(team_score) + parseInt(poin);
                message.action = 'tambah poin';
            }
            if ($(this).hasClass('btn-minus')) {
                let poin = $('#poin_salah').val();
                team_score = parseInt(team_score) - parseInt(poin);
                message.action = 'kurang poin';
            }
            if ($(this).hasClass('btn-select')) {
                is_selected = true;
            }

            message.team_id = team_id;
            message.team_score = team_score;
            message.is_selected = is_selected;

            localStorage.setItem('team-' + team_id, team_score);

            client.message = message;
            client.type = 'chat';
            client.recipient_id = "1";
            // console.log(JSON.stringify(client));
            conn.send(JSON.stringify(client));

            refresh_score();
        });
    </script>
</body>

</html>