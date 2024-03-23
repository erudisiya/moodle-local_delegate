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
 * Delegate Application List
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');

GLOBAL $DB, $CFG;
$id = optional_param('id', 0, PARAM_INT);// Delegate id.
$courseid = required_param('courseid', PARAM_INT);// Course id.
$action = optional_param('action', null, PARAM_TEXT);
$coursedetails = get_course($courseid);
$PAGE->set_context(context_course::instance($coursedetails->id));
$PAGE->set_url($CFG->wwwroot."/local/delegate/list.php");
$delegate = $DB->get_record('local_delegate', ['id' => $id]);

$PAGE->navbar->add(get_string("myhome"), new moodle_url('/my'));
$PAGE->navbar->add($coursedetails->shortname, new moodle_url('/course/view.php?id='.$courseid));
$PAGE->navbar->add(get_string("list"));
$PAGE->set_pagelayout('course');
if ($courseid) {
    $form = $CFG->wwwroot . "/local/delegate/edit.php?courseid=".$courseid;
}

// Only let users with the appropriate capability see this settings item.
if (!has_capability('local/delegate:view', context_course::instance($courseid))) {
    throw new \moodle_exception('accessdenied', 'admin');
    die;
}
if ($action == 'approve') {
    echo $OUTPUT->header();
    $yesurl = new moodle_url('/local/delegate/approve.php', array('id' => $id, 'action' => 'approve', 'courseid' => $courseid));
    $delegate = $DB->get_record('local_delegate', ['id' => $id]);
    $nourl = new moodle_url('/local/delegate/list.php', array('courseid' => $courseid));
    echo $OUTPUT->confirm(get_string('approvestr', 'local_delegate'), $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
} else if ($action == 'decline') {
    echo $OUTPUT->header();
    $yesurl = new moodle_url('/local/delegate/decline.php', array('id' => $id, 'action' => 'decline', 'courseid' => $courseid));
    $nourl = new moodle_url('/local/delegate/list.php', array('courseid' => $courseid));
    echo $OUTPUT->confirm(get_string('declinestr', 'local_delegate'), $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
}

$PAGE->set_title(get_string('delegatereqlist', 'local_delegate'));
$PAGE->set_heading(get_string('delegatereqlist', 'local_delegate'));
require_login();

$action = optional_param('action', null, PARAM_TEXT);
if ($action == 'delete') {
    echo $OUTPUT->header();
    $actionid = optional_param('id', 0, PARAM_INT);
    $yesurl = new moodle_url('/local/delegate/delete.php?id=' . $actionid . '&courseid=' . $courseid);
    $nourl = new moodle_url('/local/delegate/list.php?courseid=' . $courseid);
    echo $OUTPUT->confirm(get_string('deletestr', 'local_delegate'), $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
} else if ($action == 'approve') {
    echo $OUTPUT->header();
    $actionid = optional_param('id', 0, PARAM_INT);
    $yesurl = new moodle_url('/local/delegate/approve.php?id=' . $actionid . '&courseid=' . $courseid);
    $nourl = new moodle_url('/local/delegate/list.php');
    echo $OUTPUT->confirm(get_string('approvestr', 'local_delegate'), $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
} else if ($action == 'decline') {
    echo $OUTPUT->header();
    $actionid = optional_param('id', 0, PARAM_INT);
    $yesurl = new moodle_url('/local/delegate/decline.php?id=' . $actionid . '&courseid=' . $courseid);
    $nourl = new moodle_url('/local/delegate/list.php');
    echo $OUTPUT->confirm(get_string('declinestr', 'local_delegate'), $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
}
if (has_capability('local/delegate:approve', context_course::instance($courseid))) {
    $delegaterecords = $DB->get_recordset('local_delegate', array(), 'apply_date_time ASC');
} else {
    $delegaterecords = $DB->get_recordset('local_delegate', ['delegator' => $USER->id], 'apply_date_time ASC');
}
$table = new html_table();
$table->id = 'list';

$table->head = array(
    get_string('rownumber', 'local_delegate'),
    get_string('courses', 'local_delegate'),
    get_string('delegatee', 'local_delegate'),
    get_string('applicant', 'local_delegate'),
    get_string('start_date', 'local_delegate'),
    get_string('end_date', 'local_delegate'),
    get_string('apply_date_time', 'local_delegate'),
    get_string('approved_by', 'local_delegate'),
    get_string('approved_date', 'local_delegate'),
    get_string('staus', 'local_delegate'),
    get_string('action', 'local_delegate')
);

$table->align = array('center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'center');
$action = "";
$delegatecount = 1;
foreach ($delegaterecords as $key => $delegaterecord) {
    $delete = new moodle_url('/local/delegate/list.php',
     array('id' => $delegaterecord->id, 'action' => 'delete', 'courseid' => $courseid));

    $edit = new moodle_url('/local/delegate/edit.php', array('id' => $delegaterecord->id,
     'action' => 'update', 'courseid' => $courseid));

    $approve = new moodle_url('/local/delegate/list.php', array('id' => $delegaterecord->id,
     'action' => 'approve', 'courseid' => $courseid));

    $decline = new moodle_url('/local/delegate/list.php', array('id' => $delegaterecord->id,
     'action' => 'decline', 'courseid' => $courseid));

    $detail = new moodle_url('/local/delegate/details.php', array('id' => $delegaterecord->id, 'courseid' => $courseid));

    $course = get_course($delegaterecord->courses);
    $courselink = $CFG->wwwroot."/course/view.php?id=".$course->id;

    $coursename = html_writer::start_tag('a', array('href' => $courselink));
    $coursename .= $course->fullname;
    $coursename .= html_writer::end_tag('a');

    if ($delegaterecord->status == 0) {
        $actionstr = get_string('pending', 'local_delegate');
    } else if ($delegaterecord->status == 1) {
        $actionstr = get_string('approved', 'local_delegate');
    } else if ($delegaterecord->status == 2) {
        $actionstr = get_string('declined', 'local_delegate');
    }

    $delegateename = core_user::get_user($delegaterecord->delegatee);
    $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegaterecord->delegatee;

    $delegateenamestr = html_writer::start_tag('a', array('href' => $userprofileurl));
    $delegateenamestr .= fullname($delegateename);
    $delegateenamestr .= html_writer::end_tag('a');

    $applicantname = core_user::get_user($delegaterecord->delegator);
    $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegaterecord->delegator;

    $applicantnamestr = html_writer::start_tag('a', array('href' => $userprofileurl));
    $applicantnamestr .= fullname($applicantname);
    $applicantnamestr .= html_writer::end_tag('a');

    if ($delegaterecord->approved_by) {
        $approvername = core_user::get_user($delegaterecord->approved_by);
        $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegaterecord->approved_by;
        $approvernamestr = html_writer::start_tag('a', array('href' => $userprofileurl));
        $approvernamestr .= fullname($approvername);
        $approvernamestr .= html_writer::end_tag('a');
    } else {
        $approvernamestr = '-';
    }

    if ($delegaterecord->delegator != $USER->id) {
        if (has_capability('local/delegate:decline', context_course::instance($courseid))) {
            $action .= html_writer::start_tag('a', array('href' => $decline, 'title' => get_string('decline', 'local_delegate')));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-window-close', 'aria-hidden' => 'true'));
            $action .= html_writer::end_tag('i');
            $action .= html_writer::end_tag('a').'&nbsp';
        }
    }
    if ($delegaterecord->delegator != $USER->id) {
        if (has_capability('local/delegate:approve', context_course::instance($courseid))) {
            $action .= html_writer::start_tag('a', array('href' => $approve, 'title' => get_string('approve', 'local_delegate')));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-check-square', 'aria-hidden' => 'true'));
            $action .= html_writer::end_tag('i');
            $action .= html_writer::end_tag('a').'&nbsp';
        }
    }
    if ($delegaterecord->status == 0 && $delegaterecord->delegator == $USER->id) {
        if (has_capability('local/delegate:update', context_course::instance($courseid))) {
            $action .= html_writer::start_tag('a', array('href' => $edit, 'title' => get_string('edit', 'local_delegate')));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-pencil', 'aria-hidden' => 'true'));
            $action .= html_writer::end_tag('i');
            $action .= html_writer::end_tag('a').'&nbsp';
        }
    }
    if ($delegaterecord->status == 0 && $delegaterecord->delegator == $USER->id) {
        if (has_capability('local/delegate:delete', context_course::instance($courseid))) {
            $action .= html_writer::start_tag('a', array('href' => $delete, 'title' => get_string('delete', 'local_delegate')));
            $action .= html_writer::start_tag('i', array('class' => 'fa fa-trash', 'aria-hidden' => 'true'));
            $action .= html_writer::end_tag('i');
            $action .= html_writer::end_tag('a').'&nbsp';
        }
    }
    if (has_capability('local/delegate:view', context_course::instance($courseid))) {
        $action .= html_writer::start_tag('a', array('href' => $detail, 'title' => get_string('details', 'local_delegate')));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-external-link-square', 'aria-hidden' => 'true'));
        $action .= html_writer::end_tag('i');
        $action .= html_writer::end_tag('a').'&nbsp';
    }

    if ($delegaterecord->approved_date) {
        $approveddatestr = date('d/m/Y h:i A', $delegaterecord->approved_date);
    } else {
        $approveddatestr = '-';
    }
    $table->data[] = array(
        $delegatecount,
        $coursename,
        $delegateenamestr,
        $applicantnamestr,
        date('d/m/Y', $delegaterecord->start_date),
        date('d/m/Y', $delegaterecord->end_date),
        date('d/m/Y h:i A', $delegaterecord->apply_date_time),
        $approvernamestr,
        $approveddatestr,
        $actionstr, // 0 = pending, 1 = approved, 2 = decline.
        $action
    );
    $action = "";
    $delegatecount++;
}
$delegaterecords->close();

$tab = html_writer::start_tag('ul', array('class' => 'rui-nav-tabs nav nav-tabs'));
    $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
    $tab .= html_writer::start_tag('a', array('class' => 'nav-link active', 'title' => get_string('allaap', 'local_delegate')));
        $tab .= get_string('allaap', 'local_delegate');
    $tab .= html_writer::end_tag('a');

    $tab .= html_writer::end_tag('li');
if (has_capability('local/delegate:create', context_course::instance($courseid))) {
        $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab .= html_writer::start_tag('a', array('class' => 'nav-link', 'title' => "New Application Form", 'href' => $form));
            $tab .= get_string('application', 'local_delegate');
        $tab .= html_writer::end_tag('a');

        $tab .= html_writer::end_tag('li');
}
$tab .= html_writer::end_tag('ul');

echo $OUTPUT->header();
echo $tab;
echo html_writer::table($table);
echo $OUTPUT->footer();
