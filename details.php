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
$PAGE->requires->css('/local/delegate/style.css');
require_once($CFG->dirroot . '/local/delegate/details_form.php');

$PAGE->set_pagelayout('report');
$PAGE->set_url($CFG->wwwroot."/local/delegate/details.php");
//$PAGE->set_title("Details of Delegate Request");
//$PAGE->set_heading("Details of Delegate Request");
require_login();
$id = required_param('id', PARAM_INT);
$action = optional_param('action', null, PARAM_TEXT);
if ($id){
    if($action == 'approve') {
        echo $OUTPUT->header();
        $action_id = optional_param('id', 0, PARAM_INT);
        $yesurl = new moodle_url('/local/delegate/approve.php?id=' . $action_id);
        $nourl = new moodle_url('/local/delegate/list.php');
        echo $OUTPUT->confirm('Confirm ! Do You Want To Approve This Request?', $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    }elseif($action == 'decline') {
        echo $OUTPUT->header();
        $action_id = optional_param('id', 0, PARAM_INT);
        $yesurl = new moodle_url('/local/delegate/decline.php?id=' . $action_id);
        $nourl = new moodle_url('/local/delegate/list.php');
        echo $OUTPUT->confirm('Confirm ! Do You Want To Decline This Request?', $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    }
    $customdata = array('id' => $id);
    $mform = new delegate_form(null, $customdata);
} 

/*echo ("<pre>");
print_r($getactrec);die;*/

    


echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();

