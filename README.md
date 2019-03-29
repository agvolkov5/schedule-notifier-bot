# Schedule Notifier Bot
## About

It's a helpful tool notificating students about their classes schedule. This telegram bot wakes up via CRON and sends you a message about today's and tomorrow's schedule. You can manage a timetable in `schedule.json` file. Also, you can specify days off in this file. Here is an example of `schedule.json`:
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
					"classroom": "11",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"classroom": "41",
					"parity": "even"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"classroom": "41",
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
					"classroom": "12",
					"parity": "even"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"classroom": "89",
					"parity": "always"
				},
				{
					"title": "Sport",
					"kind": "sport",
					"classroom": "",
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
					"classroom": "65",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"classroom": "22",
					"parity": "always"
				},
				{
					"title": "Subject 3",
					"kind": "practice",
					"classroom": "16",
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
					"classroom": "71",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "practice",
					"classroom": "10",
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
					"classroom": "8",
					"parity": "odd"
				},
				{
					"title": "Subject 2",
					"kind": "lecture",
					"classroom": "1",
					"parity": "always"
				},
				{
					"title": "Sport",
					"kind": "sport",
					"classroom": "",
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
					"classroom": "10",
					"parity": "always"
				},
				{
					"title": "Subject 2",
					"kind": "sleep",
					"classroom": "10",
					"parity": "always"
				}
			]
		}
	],
	"non-coat classrooms": ["102", "105", "106"]
}
```
Note that `schedule.json` has a "non-coat classrooms" property. This is neccessary to remind students to leave their outerwear in a cloak-room, because on a specific day there will be classes in a computer classroom.

## Screenshots

<img src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot1.png" data-canonical-src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot1.png" height="300" />
<img src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot2.png" data-canonical-src="https://raw.githubusercontent.com/agvolkov5/schedule-notifier-bot/master/screenshot2.png" height="265" />
