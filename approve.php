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
 * Delegate Application
 *
 * @package   local_delegate
 * @copyright 2023 Erudisiya PVT. LTD.
 * @license   http://www.gnu.org/copyleft/gpl.html +GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
require_login();

$action = optional_param('action', null, PARAM_TEXT);
//print_r($action);
$id = optional_param('id', PARAM_TEXT);

$getactrec = get_record('local_delegate', ['id' => $id])
$updateactrec = update_record('local_delegate', data, num)
    
    $delegateobj =  new stdClass();
    $delegateobj->delegator = $USER->id;
    $delegateobj->delegatee = $fromform->delegatee;
    $delegateobj->courses = implode(",", $fromform->courses);
    $delegateobj->user_role_id = 0;
    $delegateobj->start_date = $fromform->startdate;
    $delegateobj->end_date = $fromform->enddate;
    $delegateobj->created_by = $USER->id;
    $delegateobj->reason = $fromform->reason;
    $delegateobj->status = 0; //0 = Active, 1 = Delete
    $delegateobj->apply_date_time = $now;
    $delegateobj->approved_date = "-";
    $delegateobj->approved_by = "-";
    $delegateobj->action = 0;//0 = pending, 1 = approved, 2 = decline





