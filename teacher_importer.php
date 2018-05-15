<?php

define('SYSPATH', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$database = require_once('config/database.php');

$mysqli = new mysqli(
    $database['default']['connection']['hostname'],
    $database['default']['connection']['username'],
    $database['default']['connection']['password'],
    $database['default']['connection']['database']
);

$mysqli->query("TRUNCATE nominees");
$mysqli->query("TRUNCATE courses");
$mysqli->query("TRUNCATE course_nominee");
$mysqli->query("TRUNCATE programs");
$mysqli->query("TRUNCATE program_course");

$data = json_decode(iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode(file_get_contents("https://api.tudelft.nl/v0/opleidingen/EWI"))), true);

$codes = [
    "BSc TI","MSc AM","MSc CS","BSc TW","Minors TW","Minors TI","MSc ES"
];

$courses = [];
$teachers = [];

foreach ($data['getOpleidingenByFacultyAndYearResponse']['opleiding'] as $study) {
    if (in_array($study['code'], $codes)) {
        if (!is_array($study['studieprogrammaboom']['studieprogramma'])) {
            continue;
        }
        $studies = (!key_exists('studieprogrammaboom', $study['studieprogrammaboom']['studieprogramma']))?
            $study['studieprogrammaboom']['studieprogramma']:[$study['studieprogrammaboom']['studieprogramma']];
        foreach ($studies as $study2) {
            foreach ($study2['studieprogrammaboom']['studieprogramma'] as $program) {
                $name = (key_exists('beschrijvingEN', $program) && $program['beschrijvingEN'] != "") ?
                    $program['beschrijvingEN'] : $program['beschrijvingNL'];
                $mysqli->query("INSERT INTO `programs` (name) VALUES ('$name')");
                $program_id = $mysqli->insert_id;
                if (key_exists('vak', $program)) {
                    $vakken = (!key_exists('cursusid', $program['vak']))? $program['vak']:[ $program['vak'] ];
                    parseVakken($vakken, $program_id);
                }
                if (key_exists('studieprogrammaboom', $program) && $program['studieprogrammaboom'] != null) {
                    $program2 = $program['studieprogrammaboom']['studieprogramma'];
                    if (!key_exists('vak', $program2)) {
                        if (key_exists(0, $program2)) {
                            foreach ($program2 as $program3) {
                                if (!key_exists('vak', $program3)) {
                                    continue;
                                }
                                $vakken = (!key_exists('cursusid', $program3['vak']))? $program3['vak']:[ $program3['vak'] ];
                                parseVakken($vakken, $program_id);
                            }
                        }
                        else {
                            continue;
                        }
                    } else {
                        $vakken = (!key_exists('cursusid', $program2['vak']))? $program2['vak']:[ $program2['vak'] ];
                        parseVakken($vakken, $program_id);
                    }
                }
            }
        }
    }
}

function parseVakken($vakken, $program_id) {
    global $mysqli, $courses, $teachers;
    foreach ($vakken as $course) {
        if ($course['docenten'] == null) {
            continue;
        }
        if (!key_exists($course['cursusid'], $courses)) {
            $code = $course['kortenaamNL'];
            $name = (key_exists('langenaamEN', $course) && $course['langenaamEN'] != "") ?
                $course['langenaamEN'] : $course['langenaamNL'];
            $mysqli->query("INSERT INTO `courses` (code, name) VALUES ('$code', '$name')");
            $course_id = $mysqli->insert_id;
            $courses[$course['cursusid']] = $course_id;
            $mysqli->query("INSERT INTO `program_course` (program_id, cours_id) VALUES ('$program_id', '$course_id')");
        }
        $course_id = $courses[$course['cursusid']];

        foreach ($course['docenten']['persoon'] as $teacher) {
            if (!is_array($teacher)) {
                $naam = $teacher;
                $teacher = [];
            }
            if (!key_exists('emailAdresTU', $teacher)) {
                if (!key_exists('naam', $teacher)) {
                    if (key_exists('volledigeNaam', $teacher)) {
                        $naam = $teacher['volledigeNaam'];
                    }
                    $teacher['naam'] = [ 'volledigeNaam' => $naam ];
                }
                $teacher['emailAdresTU'] = str_replace(" ", ".", strtolower($teacher['naam']['volledigeNaam'])).'@tudelft.nl';
            }
            if (!key_exists($teacher['emailAdresTU'], $teachers)) {
                $email = $teacher['emailAdresTU'];
                $name = $teacher['naam']['volledigeNaam'];
                $mysqli->query("INSERT INTO `nominees` (name, mail) VALUES ('$name', '$email')");
                $teachers[$teacher['emailAdresTU']] = $mysqli->insert_id;
            }
            $teacher_id = $teachers[$teacher['emailAdresTU']];
            $mysqli->query("INSERT INTO `course_nominee` (cours_id, nominee_id) VALUES ('$course_id', '$teacher_id')");
        }
    }
}