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
 * Delegate Application Delete
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');

GLOBAL $DB, $CFG;
require_login();

$id = required_param('id', PARAM_INT);
//print_r($id);die;


$getdelegate = $DB->get_record('local_delegate', ['id' => $id]);
//echo '<pre>';
//print_r($getdelegate);die;


$delegateobj =  new stdClass();
$delegateobj->id = $getdelegate->id;
$delegateobj->delegator = $getdelegate->delegator;
$delegateobj->delegatee = $getdelegate->delegatee;
$delegateobj->courses = $getdelegate->courses;
$delegateobj->user_role_id = $getdelegate->user_role_id;
$delegateobj->start_date = $getdelegate->start_date;
$delegateobj->end_date = $getdelegate->end_date;
$delegateobj->created_by = $getdelegate->created_by;
$delegateobj->reason = $getdelegate->reason;
$delegateobj->status = 1; //0 = Active, 1 = Delete
$delegateobj->apply_date_time = $getdelegate->apply_date_time;
$delegateobj->approved_date = $getdelegate->approved_date;
$delegateobj->approved_by = $getdelegate->approved_by;
$delegateobj->action = $getdelegate->action;//0 = pending, 1 = approved, 2 = decline
//print_r($skills);
//print_r($deleteskills);
$record = $DB->update_record('local_delegate', $delegateobj, true);

$link = $CFG->wwwroot.'/local/delegate/list.php';
redirect($link);     
