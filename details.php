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
 * Delegate Application Details
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html +GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
require_once($CFG->dirroot . '/local/delegate/lib.php');
require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot . '/local/delegate/details_form.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$action = optional_param('action', null, PARAM_TEXT);
$coursecontext = context_course::instance($courseid);
$coursedetails = get_course($courseid);
$PAGE->set_context(context_course::instance($coursedetails->id));
$PAGE->set_pagelayout('report');
$PAGE->set_url($CFG->wwwroot."/local/delegate/details.php");
$PAGE->set_title(get_string('delegatereq', 'local_delegate'));
$PAGE->set_heading(get_string('delegatereq', 'local_delegate'));
$PAGE->requires->css('/local/delegate/styles.css');
require_sesskey();
require_login($courseid);
require_capability('local/delegate:view', $coursecontext);

if ($id) {
    if ($action == 'approve') {
        echo $OUTPUT->header();
        $yesurl = new moodle_url('/local/delegate/approve.php', ['id' => $id, 'action' => 'approve']);
        $delegate = local_delegate_get($id);
        $nourl = new moodle_url('/local/delegate/list.php', ['id' => $delegate->courses]);
        echo $OUTPUT->confirm(get_string('approvestr', 'local_delegate'), $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    } else if ($action == 'decline') {
        echo $OUTPUT->header();
        $delegate = local_delegate_get($id);
        $yesurl = new moodle_url('/local/delegate/decline.php', ['id' => $id, 'action' => 'decline']);
        $nourl = new moodle_url('/local/delegate/list.php', ['id' => $delegate->courses]);
        echo $OUTPUT->confirm(get_string('declinestr', 'local_delegate'), $yesurl, $nourl);
        echo $OUTPUT->footer();
        die;
    }

    $customdata = ['id' => $id];
    $mform = new delegate_form(null, $customdata);
}
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
