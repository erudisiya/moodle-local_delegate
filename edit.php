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
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
GLOBAL $DB, $CFG;
$id = optional_param('id', 0, PARAM_INT);//course id



$PAGE->set_pagelayout('standard');
$PAGE->navbar->add(get_string("myhome"), new moodle_url('/my'));
if ($id){
    $course = get_course($id);
    $PAGE->set_context(context_course::instance($course->id));
    $PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php?id='.$id));
    $PAGE->navbar->add(get_string("allaap", "local_delegate"), new moodle_url('/local/delegate/list.php?id='.$id));
} else {
    $PAGE->set_context(context_system::instance());
}

$PAGE->navbar->add(get_string("pluginname", "local_delegate"));
$PAGE->set_url($CFG->wwwroot."/local/delegate/edit.php");

$PAGE->set_title(get_string('applystr', 'local_delegate'));
require_login();

require_once("$CFG->libdir/formslib.php");
//include edit_form.php
require_once($CFG->dirroot . '/local/delegate/delegate_application_form.php');

if (isset($id) && ($id > 0)){
    $customdata = array('id' => $id);
    //Instantiate simplehtml_form 
    $mform = new delegate_application_form(null, $customdata);
} else {
    //Instantiate simplehtml_form 
    $mform = new delegate_application_form();
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

    //print_r($delegateobj);die;
    //$delegateobj->skillid = $fromform->skillid;

    if (!empty($fromform->id)) {
        $existingdelegate = $DB->get_record('local_delegate', array("id" => $fromform->id));
        $delegateobj->id = $fromform->id;
        $record = $DB->update_record('local_delegate', $delegateobj, true);
    } else {
        
        $record = $DB->insert_record('local_delegate', $delegateobj, true);

    }
    
    redirect($CFG->wwwroot."/local/delegate/list.php");
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
  $mform->display();
  echo $OUTPUT->footer();
}