<?php
	function send_message($text) {
		$token = file_get_contents('token.txt');
		$production_channel_id = file_get_contents('channel_id.txt');
		$test_channel_id = file_get_contents('test_channel_id.txt');

		$envelope = array(
			"chat_id" => $production_channel_id,
			"text" => $text,
			"parse_mode" => "Markdown"
		);

		$ch = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage');
		curl_setopt_array($ch, array(
			CURLOPT_POST => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPHEADER => array(
 				'Content-Type: application/json'
			),
			CURLOPT_POSTFIELDS => json_encode($envelope)
		));

		$response = curl_exec($ch);

		if($response === FALSE){
			die(curl_error($ch));
		}

		return $response;
	}

	function will_be_class($parity, $weeknumber) {
		return $parity === 'always'
			|| (!($weeknumber % 2) && $parity === 'even')
			|| (($weeknumber % 2) && $parity === 'odd');
	}

	function jacket_is_need($schedule, $weekday, $weeknumber) {
		$non_jacket_auds = $schedule['non-jacket auditoriums'];
		$aud = substr($aud, 0, 3);

		$need = false;
		foreach ($schedule['schedule'][$weekday-1]['classes'] as $number => $class) {
			if (willBeClass($class['parity'], $weeknumber)) {
				$aud = substr($class['auditorium'], 0, 3);
				if (in_array($aud, $non_jacket_auds)) {
					$need = true;
				}
			}
		}
		return $need;
	}

	function render_shedule_to_message($schedule, $weekday, $weeknumber) {
		$schedule_today = $schedule['schedule'][$weekday-1];
		$sports_emoji = ["🏐", "⛹🏻‍♂️", "⚽️", "🤸‍♂️", "🎾", "🏃‍♀️"];

		$message_text = '';
		foreach ($schedule_today['classes'] as $number => $class) {
			if (willBeClass($class['parity'], $weeknumber)) {
				$message_text .= "_" . $schedule['timetable'][$schedule_today['number_of_first_class'] + $number - 1][0] . "_ ";
				$message_text .= $class['title'] . ' ';
				switch ($class['kind']) {
					case 'lecture':
						$message_text .= "🗣 ";
						break;
					case 'sleep':
						$message_text .= "💤 ";
						break;
					case 'sport':
						$message_text .= $sports_emoji[($weeknumber - 12)%count($sports_emoji)] . " ";
						break;
				}
				$message_text .= "_" . $class['auditorium'] . "_";
				$message_text .= "\n";
			}
		}
		return $message_text;
	}

	$weekday = date('w');
	$weeknumber = date('W');
	$result = date('Y-m-d h:i');
	$schedule = json_decode(file_get_contents('schedule.json'), true);

// For today
	$message_text = 'Сегодня:';
	if (jacket_is_need($schedule, $weekday, $weeknumber)) {
		$message_text .= " 🧥";
	}
	$message_text .= "\n";

	$message_text .= renderSheduleToMessage($schedule, $weekday, $weeknumber);
	$message_text .= "\n";

	$message_text .= 'Пары закончатся в ';
	$number_of_last_class = count($schedule['schedule'][$weekday-1]['classes']) + $schedule['schedule'][$weekday-1]['number_of_first_class'] - 1;
	$message_text .= $schedule['timetable'][$number_of_last_class - 1][1];
	$message_text .= "\n";

// For tomorrow
	$tomorrow_weekday = $weekday + 1;
	$tomorrow_weeknumber = $weeknumber;
	if ($tomorrow_weekday > 6) {
		$tomorrow_weekday = 1;
		$tomorrow_weeknumber++;
		$message_text .= "Завтра выходной :)\n\nПонедельник:";
	} else {
		$message_text .= "\nЗавтра:";
	}

	if (jacket_is_need($schedule, $tomorrow_weekday, $tomorrow_weeknumber)) {
		$message_text .= " 🧥";
	}
	$message_text .= "\n";
	$message_text .= renderSheduleToMessage($schedule, $tomorrow_weekday, $tomorrow_weeknumber);

	// echo $message_text;
	$response = json_decode(sendMessage($message_text), true);
	// $chat_id = $response['result']['chat']['id'];

	// $chat_id_file = fopen('chat_id.txt', 'w') or die('Unable to open file!');
	// fwrite($chat_id_file, $chat_id);
	// fclose($chat_id_file);