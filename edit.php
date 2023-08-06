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
 * Delegate Application Handling
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot . '/local/delegate/lib.php');
//include delegate_application_form.php
require_once($CFG->dirroot . '/local/delegate/delegate_application_form.php');
$id = optional_param('id', 0, PARAM_INT);//delegatee id
$courseid = optional_param('courseid', 0, PARAM_INT);//course id

$coursedetails = get_course($courseid);

$PAGE->set_pagelayout('standard');
$PAGE->navbar->add(get_string("myhome"), new moodle_url('/my'));
$PAGE->navbar->add($coursedetails->shortname, new moodle_url('/course/view.php', array('id' => $courseid)));
$PAGE->navbar->add(get_string("list"), new moodle_url('/local/delegate/list.php?courseid='.$courseid));
$PAGE->navbar->add(get_string("edit"));
if ($id){
    $course = get_course($courseid);
    $PAGE->set_context(context_course::instance($course->id));
    $PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php?id='.$id));
    $PAGE->navbar->add(get_string("allaap", "local_delegate"), new moodle_url('/local/delegate/list.php?id='.$id));
    $form = new moodle_url('/local/delegate/list.php', array('id' => $id, 'courseid' => $courseid));
} else {
    $PAGE->set_context(context_system::instance());
    $form = $CFG->wwwroot . "/local/delegate/list.php?courseid=".$courseid;
}

$PAGE->set_url($CFG->wwwroot."/local/delegate/list.php");

$PAGE->set_title(get_string('applystr', 'local_delegate'));
require_login();
$tab = html_writer::start_tag('ul', array('class' => 'rui-nav-tabs nav nav-tabs'));
    $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab .= html_writer::start_tag('a', array('class' => 'nav-link','title'=>"All Application List", 'href'=>$form));
            $tab .= get_string('allaap', 'local_delegate');
        $tab .= html_writer::end_tag('a');

    $tab .= html_writer::end_tag('li');

    $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab .= html_writer::start_tag('a', array('class' => 'nav-link active','title'=>"New Application Form"));
            $tab .= get_string('application', 'local_delegate');
        $tab .= html_writer::end_tag('a');

    $tab .= html_writer::end_tag('li');
$tab .= html_writer::end_tag('ul');


if ($courseid){
    $customdata = array('id' => $id, 'courseid' => $courseid);
    $mform = new delegate_application_form(null, $customdata);
} else {
    $customdata = array('courseid' => $courseid);
    $mform = new delegate_application_form(null, $customdata);
}

    

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot."/local/delegate/list.php");
} else if ($fromform = $mform->get_data()) {
    
    $now=time();
    $delegateobj =  new stdClass();
    $delegateobj->delegator = $USER->id;
    $delegateobj->delegatee = $fromform->delegatee;
    $delegateobj->courses = $fromform->courseid;
    $delegateobj->user_role_id = 0;
    $delegateobj->start_date = $fromform->startdate;
    $delegateobj->end_date = $fromform->enddate;
    $delegateobj->created_by = $USER->id;
    $delegateobj->reason = $fromform->reason;
    $delegateobj->status = 0; //0 = Active, 1 = Delete
    $delegateobj->apply_date_time = $now;
    $delegateobj->approved_date = 0;
    $delegateobj->approved_by = 0;
    $delegateobj->modifyed_by = $USER->id;
    $delegateobj->modify_datetime = $now;
    $delegateobj->action = 0;//0 = pending, 1 = approved, 2 = decline

    if (!empty($fromform->id)) {
        $delegateobj->id = $fromform->id;
        $DB->update_record('local_delegate', $delegateobj, true);

        send_notification($delegateobj);
    } else {
        
        $newdelegate = $DB->insert_record('local_delegate', $delegateobj, true);
        $delegate = get_delegate($newdelegate);
        send_notification($delegate);
    }
    
    redirect($CFG->wwwroot."/local/delegate/list.php?courseid=".$courseid);
  //In this case you process validated data. $mform->get_data() returns data posted in form.
} else {

    if (isset($id) && ($id > 0)) {
        $delegaterec = $DB->get_record('local_delegate', array("id" => $id));
        //print_r($delegaterec);die;
        $delegaterec->startdate = $delegaterec->start_date;
        $delegaterec->enddate = $delegaterec->end_date;
        $delegaterec->courses = explode(",", $delegaterec->courses);
        //print_r($delegaterec);die;
        //$delegaterec->start_date = ;
        $mform->set_data($delegaterec); //Set default data (if any)
    }

  //Set default data (if any)
  //$mform->set_data($toform);
  //displays the form
  echo $OUTPUT->header();
  echo $tab;
  $mform->display();
  echo $OUTPUT->footer();
}