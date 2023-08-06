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
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html +GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
$PAGE->set_pagelayout('report');

//$PAGE->set_pagelayout('standard');
//$PAGE->set_url($CFG->wwwroot."/local/skills/new_training_allowance_form.php");
$PAGE->set_context(context_system::instance());
//$PAGE->set_title("New Training Allowance Form");
//$PAGE->set_heading("New Training Allowance Form");
require_login();
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class delegate_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG, $DB;
        $mform = $this->_form; // Don't forget the underscore!
        if (isset($this->_customdata['id'])) {
            $id = $this->_customdata['id'];//delegate id
            $delegate = $DB->get_record('local_delegate', ['id' => $id]);
            $course = get_course($delegate->courses);
            $courselink = $CFG->wwwroot."/course/view.php?id=".$course->id;
            $delegateename = core_user::get_user($delegate->delegatee);
            $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegate->delegatee;
            //print_r($delegateename);die;

            $delegateenamestr = html_writer::start_tag('a', array('href' => $userprofileurl));
            $delegateenamestr .= fullname($delegateename);   
            $delegateenamestr .= html_writer::end_tag('a');
            $coursename = html_writer::start_tag('a', array('href' => $courselink));
            $coursename .= $course->fullname;
            $coursename .= html_writer::end_tag('a');
            $mform->addElement('header', 'delegatedetails', get_string('delegatedetails', 'local_delegate'));
            $mform->addElement('static', 'course', get_string('courses', 'local_delegate'), $coursename);
            $mform->addElement('static', 'delegateename', get_string('delegatee', 'local_delegate'), $delegateenamestr);
            $mform->addElement('static', 'startdate', get_string('startdate', 'local_delegate'), date('d-M-Y', $delegate->start_date)); 
            $mform->addElement('static', 'enddate', get_string('enddate', 'local_delegate'), date('d-M-Y', $delegate->end_date)); 
            $mform->addElement('static', 'applydatetime', get_string('apply_date_time', 'local_delegate'), date('d-M-Y h:i A', $delegate->apply_date_time));
            $approve = new moodle_url('/local/delegate/details.php', array('id' => $delegate->id, 'action' => 'approve'));
            $decline = new moodle_url('/local/delegate/details.php', array('id' => $delegate->id, 'action' => 'decline'));
            $action = html_writer::start_tag('div', array('class' => 'actionholder'));
            $action .= html_writer::start_tag('a', array('href' => $decline, 'class' => 'btn-decline btn-action'));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-window-close','aria-hidden'=>'true'));
            $action .= html_writer::end_tag('i'); 
            $action .= get_string('decline', 'local_delegate');  
            $action .= html_writer::end_tag('a').'&nbsp';

            $action .= html_writer::start_tag('a', array('href' => $approve, 'class' => 'btn-approve btn-action'));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-check-square','aria-hidden'=>'true'));

            $action .= html_writer::end_tag('i');
            $action .= get_string('approve', 'local_delegate');
            $action .= html_writer::end_tag('a');
            $action .= html_writer::end_tag('div');   
            $mform->addElement('html', $action);
        }
    }
}
