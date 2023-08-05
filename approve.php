<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version. 
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Delegate Application Approve
 *
 * @package   local_delegate
 * @copyright 2023 Erudisiya PVT. LTD.
 * @license   http://www.gnu.org/copyleft/gpl.html +GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
require_login();

$action = required_param('action', PARAM_TEXT);
//print_r($action);
$id = required_param('id', PARAM_INT);

$delegate = $DB->get_record('local_delegate', ['id' => $id]);
$courseid = $delegate->courses;//course id

$now=time();
$delegateobj = new stdClass();
$delegateobj->id = $delegate->id;
$delegateobj->approved_date = $now;
$delegateobj->approved_by = $USER->id;
$delegateobj->action = 1;//0 = pending, 1 = approved, 2 = declined

$updateactrec = $DB->update_record('local_delegate', $delegateobj, true);

$link = $CFG->wwwroot."/local/delegate/list.php?courseid=".$courseid;
redirect($link);



