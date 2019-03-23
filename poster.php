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

	function cloak_room_is_need($schedule, $weekday, $weeknumber) {
		$non_coat_auds = $schedule['non-coat classrooms'];
		$aud = substr($aud, 0, 3);

		$need = false;
		foreach ($schedule['schedule'][$weekday-1]['classes'] as $number => $class) {
			if (will_be_class($class['parity'], $weeknumber)) {
				$aud = substr($class['classroom'], 0, 3);
				if (in_array($aud, $non_coat_auds)) {
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
			if (will_be_class($class['parity'], $weeknumber)) {
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
				$message_text .= "_" . $class['classroom'] . "_";
				$message_text .= "\n";
			}
		}
		return $message_text;
	}

	$weekday = date('w');
	$weeknumber = date('W');
	$weekdays = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
	$result = date('Y-m-d h:i');
	$schedule = json_decode(file_get_contents('schedule.json'), true);

	$date_today = date('d-m-Y');

	if (!in_array($date_today, $schedule['days_off'])
		&& ($weekday % 7 !== 0)) {
	// For today
		echo "Working..", "<br/>";
		$message_text = 'Сегодня:';
		if (cloak_room_is_need($schedule, $weekday, $weeknumber)) {
			$message_text .= " 🧥";
		}
		$message_text .= "\n";

		$message_text .= render_shedule_to_message($schedule, $weekday, $weeknumber);
		$message_text .= "\n";

		$variety = [
			'Пары до ',
			'Пары закончатся в ',
			'Учёба до '
		];
		$message_text .= $variety[array_rand($variety)];
		$number_of_last_class = count($schedule['schedule'][$weekday-1]['classes']) + $schedule['schedule'][$weekday-1]['number_of_first_class'] - 1;
		$message_text .= $schedule['timetable'][$number_of_last_class - 1][1];
		$message_text .= ".\n";
		if (cloak_room_is_need($schedule, $weekday, $weeknumber)) {
			$variety = [
				'Придётся зайти в гардероб.',
				'Надо будет сдать куртку.',
				'Не всегда хочется сдавать куртку, но сегодня нужно.',
				'Сегодня не без гардероба.'
			];
		} else {
			$variety = [
				'Можно разделить пары с курткой)',
				'Куртку можно оставить при себе)',
				'Любовь - это когда куртка рядом 💕'
			];
		}
		$message_text .= $variety[array_rand($variety)];
		$message_text .= "\n";

	// For tomorrow
		$next_date = new DateTime('tomorrow');
		$next_weekday = (int)$next_date->format('w');

		$number_of_days_off = 0;
		while (($next_weekday % 7 === 0)
			|| (in_array($next_date->format('d-m-Y'), $schedule['days_off']))) {
			$next_date->modify("+1 day");
			$number_of_days_off++;
			// $message_text .= "Завтра выходной :)\n\nПонедельник:";
			$next_weekday = (int)$next_date->format('w');
			$next_weeknumber = (int)$next_date->format('W');
		}

		switch ($number_of_days_off) {
			case 0:
				$message_text .= "\nЗавтра:";
				break;
			case 1:
				$message_text .= "\nЗавтра выходной 😉\n\n" . $weekdays[$next_weekday - 1] . ":";
			default:
				$message_text .= "\nНаступили выходные 😎\n\n" . $weekdays[$next_weekday - 1] . ":";
				break;
		}

		echo $next_date->format('d-m-Y'), " ", $number_of_days_off, "<br/>";
		echo $next_weeknumber, "<br/>";
		echo $next_weekday;

		if (cloak_room_is_need($schedule, $next_weekday, $next_weeknumber)) {
			$message_text .= " 🧥";
		}
		$message_text .= "\n";
		$message_text .= render_shedule_to_message($schedule, $next_weekday, $next_weeknumber);

	// echo $message_text;

		$response = json_decode(send_message($message_text), true);
	}
	// $chat_id = $response['result']['chat']['id'];

	// $chat_id_file = fopen('chat_id.txt', 'w') or die('Unable to open file!');
	// fwrite($chat_id_file, $chat_id);
	// fclose($chat_id_file);