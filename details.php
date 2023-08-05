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
$PAGE->set_title(get_string('delegatereq', 'local_delegate'));
$PAGE->set_heading(get_string('delegatereq', 'local_delegate'));
require_login();
$id = required_param('id', PARAM_INT);
$action = optional_param('action', null, PARAM_TEXT);
if ($id){
    if ($action == 'approve') {
        echo $OUTPUT->header();
        $yesurl = new moodle_url('/local/delegate/approve.php', array('id' => $id, 'action' => 'approve'));
        $delegate = $DB->get_record('local_delegate', ['id' => $id]);
        $nourl = new moodle_url('/local/delegate/list.php', array('id' => $delegate->courses));
        echo $OUTPUT->confirm(get_string('approvestr', 'local_delegate'), $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    } elseif ($action == 'decline') {
        echo $OUTPUT->header();
        $yesurl = new moodle_url('/local/delegate/decline.php', array('id' => $id, 'action' => 'decline'));
        $nourl = new moodle_url('/local/delegate/list.php', array('id' => $delegate->courses));
        echo $OUTPUT->confirm(get_string('declinestr', 'local_delegate'), $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    }
    $customdata = array('id' => $id);
    $mform = new delegate_form(null, $customdata);
} 

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();

