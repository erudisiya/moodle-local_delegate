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
class delegate_form extends moodleform {
    // Add elements to form.
    public function definition() {
        global $CFG, $DB, $USER;
        $mform = $this->_form; // Don't forget the underscore!
        if (isset($this->_customdata['id'])) {
            $id = $this->_customdata['id'];// Delegate id.

            $delegate = $DB->get_record('local_delegate', ['id' => $id]);
            $course = get_course($delegate->courses);
            $courselink = $CFG->wwwroot."/course/view.php?id=".$course->id;
            $delegateename = core_user::get_user($delegate->delegatee);
            $applicantname = core_user::get_user($delegate->delegator);
            $approvedby = core_user::get_user($delegate->approved_by);

            $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegate->delegatee;

            $delegateenamestr = html_writer::start_tag('a', ['href' => $userprofileurl]);
            $delegateenamestr .= fullname($delegateename);
            $delegateenamestr .= html_writer::end_tag('a');

            $applicantnamestr = html_writer::start_tag('a', ['href' => $userprofileurl]);
            $applicantnamestr .= fullname($applicantname);
            $applicantnamestr .= html_writer::end_tag('a');

            $approvedbynamestr = html_writer::start_tag('a', ['href' => $userprofileurl]);
            $approvedbynamestr .= fullname($approvedby);
            $approvedbynamestr .= html_writer::end_tag('a');

            $coursename = html_writer::start_tag('a', ['href' => $courselink]);
            $coursename .= $course->fullname;
            $coursename .= html_writer::end_tag('a');
            $mform->addElement('header', 'delegatedetails', get_string('delegatedetails', 'local_delegate'));
            $mform->addElement('static', 'course', get_string('courses', 'local_delegate'), $coursename);
            $mform->addElement('static', 'delegateename', get_string('delegatee', 'local_delegate'), $delegateenamestr);
            $mform->addElement('static', 'applicantname', get_string('applicantname', 'local_delegate'), $applicantnamestr);
            $mform->addElement('static', 'startdate', get_string('startdate', 'local_delegate'),
             date('d-M-Y', $delegate->start_date));
            $mform->addElement('static', 'enddate', get_string('enddate', 'local_delegate'),
             date('d-M-Y', $delegate->end_date));
            $mform->addElement('static', 'applydatetime',
             get_string('apply_date_time', 'local_delegate'), date('d-M-Y h:i A', $delegate->apply_date_time));
            $mform->addElement('static', 'reason', get_string('reason', 'local_delegate'), $delegate->reason);

            if (($delegate->status == 1 || 2) && ($delegate->approved_by != 0)) {
                $mform->addElement('static', 'approvedby', get_string('approved_by', 'local_delegate'), $approvedbynamestr);
            } else {
                $mform->addElement('static', 'approvedby', get_string('dotpending', 'local_delegate'));
            }

            $approve = new moodle_url('/local/delegate/details.php', ['id' => $delegate->id, 'action' => 'approve']);
            $decline = new moodle_url('/local/delegate/details.php', ['id' => $delegate->id, 'action' => 'decline']);
            if ($delegate->status == 0) {
                if (has_capability('local/delegate:approve',
                 context_course::instance($course->id)) && ($USER->id != $delegate->delegator)) {
                    $approvedeclineflag = 1;
                } else if (is_siteadmin()) {
                    $approvedeclineflag = 1;
                } else {
                    $approvedeclineflag = 0;
                }
            } else {
                $approvedeclineflag = 0;
            }
            if ($approvedeclineflag) {
                $action = html_writer::start_tag('div', ['class' => 'localdelegate']);
                $action .= html_writer::start_tag('div', ['class' => 'actionholder']);
                $action .= html_writer::start_tag('a', ['href' => $decline, 'class' => 'btn-decline btn-action']);

                $action .= html_writer::start_tag('i', ['class' => 'fa fa-window-close', 'aria-hidden' => 'true']);
                $action .= html_writer::end_tag('i');
                $action .= get_string('decline', 'local_delegate');
                $action .= html_writer::end_tag('a').'&nbsp';

                $action .= html_writer::start_tag('a', ['href' => $approve, 'class' => 'btn-approve btn-action']);
                $action .= html_writer::start_tag('i', ['class' => 'fa fa-check-square', 'aria-hidden' => 'true']);

                $action .= html_writer::end_tag('i');
                $action .= get_string('approve', 'local_delegate');
                $action .= html_writer::end_tag('a');
                $action .= html_writer::end_tag('div');
                $action .= html_writer::end_tag('div');/*localdelegate*/
                $mform->addElement('html', $action);
            }
        }
    }
}
