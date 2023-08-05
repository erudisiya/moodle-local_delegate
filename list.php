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
$id = optional_param('id', 0, PARAM_INT);//delegate id
$courseid = optional_param('courseid', 0, PARAM_INT);//course id

$PAGE->set_pagelayout('report');
$PAGE->set_url($CFG->wwwroot."/local/delegate/list.php");
$coursedetails = get_course($courseid);
$PAGE->navbar->add(get_string("myhome"), new moodle_url('/my'));
$PAGE->navbar->add($coursedetails->shortname, new moodle_url('/course/view.php?id='.$courseid));
$PAGE->navbar->add(get_string("list"));
$PAGE->set_context(context_course::instance($coursedetails->id));
if ($id) {
    $form = $CFG->wwwroot . "/local/delegate/edit.php?id=?".$id."&courseid=".$courseid;
} else {
    $form = $CFG->wwwroot . "/local/delegate/edit.php?courseid=".$courseid;
}


$PAGE->set_title("Request for Delegate");
$PAGE->set_heading("Request for Delegate");
require_login();

$action = optional_param('action', null, PARAM_TEXT);
//print_r($action);
if ($action == 'delete') {
    echo $OUTPUT->header();
    $action_id = optional_param('id', 0, PARAM_INT);
    $yesurl = new moodle_url('/local/delegate/delete.php?id=' . $action_id);
    $nourl = new moodle_url('/local/delegate/list.php');
    echo $OUTPUT->confirm('Confirm ! Do You Want To Delete This Request?', $yesurl, $nourl);
    echo $OUTPUT->footer();
    die;
}elseif($action == 'approve') {
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

$delegaterecords = $DB->get_records('local_delegate',['status' => '0']);
/*$rs = $DB->get_recordset(....);
foreach ($rs as $record) {
    // Do whatever you want with this record
}
$rs->close();*/
/*echo "<pre>";
print_r($delegaterecords);die;*/
$table = new html_table();
$table->id = 'list';/*echo '<pre>';*/

$table->head = array(
    get_string('courses', 'local_delegate'),
    get_string('delegatee', 'local_delegate'),
    get_string('start_date', 'local_delegate'),
    get_string('end_date', 'local_delegate'),
    get_string('apply_date_time', 'local_delegate'),
    get_string('approved_by', 'local_delegate'),
    get_string('approved_date', 'local_delegate'),
    get_string('staus', 'local_delegate'),
    get_string('action', 'local_delegate')
);

$table->align = array('center','center','center','center','center','center','center','center');

foreach ($delegaterecords as $key => $delegaterecord) {
    $delete = new moodle_url('/local/delegate/list.php', array('id' => $delegaterecord->id, 'courseid' => $courseid, 'action' => 'delete'));

    $edit = new moodle_url('/local/delegate/edit.php', array('id' => $delegaterecord->id, 'courseid' => $courseid, 'action' => 'update'));

    $approve = new moodle_url('/local/delegate/approve.php', array('id' => $delegaterecord->id, 'courseid' => $courseid, 'action' => 'approve'));
    
    $decline = new moodle_url('/local/delegate/decline.php', array('id' => $delegaterecord->id, 'courseid' => $courseid, 'action' => 'decline'));
    

    $course = get_course($delegaterecord->courses);
    $courselink = $CFG->wwwroot."/course/view.php?id=".$course->id;

    $coursename = html_writer::start_tag('a', array('href' => $courselink));
    $coursename .= $course->fullname;
    $coursename .= html_writer::end_tag('a');
    //die;
    
    if($delegaterecord->action == 0){
        $actionstr ='Pending';
    } elseif($delegaterecord->action == 1){
       $actionstr ='Approved';
    } elseif($delegaterecord->action == 2){
       $actionstr ='Declined';
    };
    $delegateename = core_user::get_user($delegaterecord->delegatee);
    $userprofileurl = $CFG->wwwroot."/user/profile.php?id=".$delegaterecord->delegatee;
    //print_r($delegateename);die;

    $delegateenamestr = html_writer::start_tag('a', array('href' => $userprofileurl));
    $delegateenamestr .= fullname($delegateename);   
    $delegateenamestr .= html_writer::end_tag('a');

    if (is_siteadmin()){
    $action = html_writer::start_tag('a', array('href' => $decline));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-window-close','aria-hidden'=>'true'));
        $action .= html_writer::end_tag('i');   
    $action .= html_writer::end_tag('a').'&nbsp';

    $action .= html_writer::start_tag('a', array('href' => $approve ));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-check-square','aria-hidden'=>'true'));
        $action .= html_writer::end_tag('i');   
    $action .= html_writer::end_tag('a');

    }else{

    $action = html_writer::start_tag('a', array('href' => $edit));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-pencil','aria-hidden'=>'true'));
        $action .= html_writer::end_tag('i');   
    $action .= html_writer::end_tag('a').'&nbsp';
    $action .= html_writer::start_tag('a', array('href' => $delete));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-trash','aria-hidden'=>'true'));
        $action .= html_writer::end_tag('i');   
    $action .= html_writer::end_tag('a');
    }


    $table->data[] = array(
        $coursename,
        //$delegaterecord->courses,
        $delegateenamestr,
        date('d-M-Y', $delegaterecord->start_date),
        date('d-M-Y', $delegaterecord->end_date),
        date('d-M-Y h:i A', $delegaterecord->apply_date_time),
        $delegaterecord->approved_by,
        $delegaterecord->approved_date,
        $actionstr,//0 = pending, 1 = approved, 2 = decline
        $action
    );  
}




$tab = html_writer::start_tag('ul', array('class' => 'rui-nav-tabs nav nav-tabs'));
    $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab .= html_writer::start_tag('a', array('class' => 'nav-link active','title'=>"All Application List"));
            $tab .= get_string('allaap', 'local_delegate');
        $tab .= html_writer::end_tag('a');

    $tab .= html_writer::end_tag('li');

    $tab .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab .= html_writer::start_tag('a', array('class' => 'nav-link','title'=>"New Application Form",'href'=>$form));
            $tab .= get_string('application', 'local_delegate');
        $tab .= html_writer::end_tag('a');

    $tab .= html_writer::end_tag('li');
$tab .= html_writer::end_tag('ul');

   



echo $OUTPUT->header();
echo $tab;
echo html_writer::table($table);
echo $OUTPUT->footer();

 