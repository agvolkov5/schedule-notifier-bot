# Schedule Notifier Bot
## About

Helpful solution notificating students about classes schedule. This telegram bot wakes up via CRON and sends message about a today's and tomorrow's schedule. You can manage a timetable in `schedule.json` file. Also, you can point a days off in this file. An example of `schedule.json`:
```json
{
	"timetable": [
		["8:00", "9:30"],
		["9:40", "11:10"],
		["11:30", "13:00"],
		["13:10", "14:40"],
		["15:00", "16:30"],
		["16:40", "18:10"],
		["18:20", "19:50"]
	],
  	"days_off": ["25-03-2019", "01-05-2019"],
	"schedule": [
		{
			"weekday": "Monday",
			"number_of_first_class": 1,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "lecture",
					"auditorium": "11",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"auditorium": "41",
					"parity": "even"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"auditorium": "41",
					"parity": "odd"
				}
			]
		},
		{
			"weekday": "Tuesday",
			"number_of_first_class": 2,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "practice",
					"auditorium": "12",
					"parity": "even"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"auditorium": "89",
					"parity": "always"
				},
				{
					"title": "Sport",
					"kind": "sport",
					"auditorium": "",
					"parity": "odd"
				}
			]
		},
		{
			"weekday": "Wednesday",
			"number_of_first_class": 1,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "practice",
					"auditorium": "65",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"auditorium": "22",
					"parity": "always"
				},
				{
					"title": "Subject 3",
					"kind": "practice",
					"auditorium": "16",
					"parity": "even"
				}
			]
		},
		{
			"weekday": "Thursday",
			"number_of_first_class": 2,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "lecture",
					"auditorium": "71",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"auditorium": "10",
					"parity": "always"
				}
			]
		},
		{
			"weekday": "Friday",
			"number_of_first_class": 1,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "lecture",
					"auditorium": "8",
					"parity": "odd"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"auditorium": "1",
					"parity": "always"
				},
				{
					"title": "Sport",
					"kind": "sport",
					"auditorium": "",
					"parity": "always"
				}
			]
		},
		{
			"weekday": "Saturday",
			"number_of_first_class": 2,
			"classes": [
				{
					"title": "Subject 1",
					"kind": "sleep",
					"auditorium": "10",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "sleep",
					"auditorium": "10",
					"parity": "always"
				}
			]
		}
	],
	"non-jacket auditoriums": ["102", "105", "106"]
}
```
Notice, `schedule.json` has a "non-jacket auditoriums" property. This is needed to alert students to leave their outerwear in a wardrobe, because today will be classes in a computer auditoriums.

## Screenshots

<img src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot1.png" data-canonical-src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot1.png" height="300" />
<img src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot2.png" data-canonical-src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot2.png" height="265" />
