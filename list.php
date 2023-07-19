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

$PAGE->set_pagelayout('report');
$PAGE->set_url($CFG->wwwroot."/local/delegate/list.php");
$id = optional_param('id', 0, PARAM_INT);//course id
if ($id) {
    $course = get_course($id);
    $PAGE->set_context(context_course::instance($course->id));
    $form = $CFG->wwwroot . "/local/delegate/edit.php?id=".$id;
} else {
    $PAGE->set_context(context_system::instance());
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

$delrecords = $DB->get_records('local_delegate',['status' => '0']);
/*echo "<pre>";
print_r($delrecords);die;*/
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

foreach ($delrecords as $key => $delrecord) {
    $delete = $CFG->wwwroot."/local/delegate/list.php?action=delete&id=".$delrecord->id;
    $edit = $CFG->wwwroot."/local/delegate/edit.php?action=update&id=".$delrecord->id;
    $approve = $CFG->wwwroot."/local/delegate/approve.php?action=approve&id=".$delrecord->id;
    $decline = $CFG->wwwroot."/local/delegate/decline.php?action=decline&id=".$delrecord->id;

    $courseids = explode(",", $delrecord->courses);
    //print_r($delrecord);die;
    $courselength = count($courseids);
    $coursecounter = 0;
    $coursename = "";
    //echo "<pre>";
    foreach ($courseids as $key => $courseid) {
        //print_r($courseid)
        $coursedetail = $DB->get_record('course',['id'=>$courseid]);
        $courselink = $CFG->wwwroot."/course/view.php?id=".$courseid;
        //print_r($courselink);die;
        $coursecounter++;
            if($coursecounter<$courselength){
                $coursename .= html_writer::start_tag('a', array('href' => $courselink));
                    $coursename .= $coursedetail->fullname;   
                $coursename .= html_writer::end_tag('a').", "; 
                 
            }else{
                $coursename .= html_writer::start_tag('a', array('href' => $courselink));
                    $coursename .= $coursedetail->fullname;   
                $coursename .= html_writer::end_tag('a');
                
            }
    }
    //echo $coursename;
    //die;
    $delegateename = $DB->get_record('user',['id'=>$delrecord->delegatee]);
    
    if($delrecord->action == 0){
        $actionstr ='Pending';
    }elseif($delrecord->action == 1){
       $actionstr ='Approved';
    }elseif($delrecord->action == 2){
       $actionstr ='Declined';
    };
    
    $delname = fullname($delegateename);
    $namelink = $CFG->wwwroot."/user/profile.php?id=".$delrecord->delegatee;
    //print_r($delegateename);die;

    $dgeteename = html_writer::start_tag('a', array('href' => $namelink));
        $dgeteename .= $delname;   
    $dgeteename .= html_writer::end_tag('a');

    if (is_siteadmin()){
        $action = html_writer::start_tag('a', array('href' => $approve));
        $action .= html_writer::start_tag('i', array('class' => 'fa fa-window-close','aria-hidden'=>'true'));
        $action .= html_writer::end_tag('i');   
    $action .= html_writer::end_tag('a').'&nbsp';
    $action .= html_writer::start_tag('a', array('href' => $decline ));
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
        //$delrecord->courses,
        $dgeteename,
        date('d-M-Y', $delrecord->start_date),
        date('d-M-Y', $delrecord->end_date),
        date('d-M-Y h:i A', $delrecord->apply_date_time),
        $delrecord->approved_by,
        $delrecord->approved_date,
        $actionstr,//0 = pending, 1 = approved, 2 = decline
        $action
    );  
}




$tab1 = html_writer::start_tag('ul', array('class' => 'rui-nav-tabs nav nav-tabs'));
    $tab1 .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab1 .= html_writer::start_tag('a', array('class' => 'nav-link active','title'=>"All Application List"));
            $tab1 .= get_string('allaap', 'local_delegate');
        $tab1 .= html_writer::end_tag('a');

    $tab1 .= html_writer::end_tag('li');

    $tab1 .= html_writer::start_tag('li', array('class' => 'nav-item'));
        $tab1 .= html_writer::start_tag('a', array('class' => 'nav-link','title'=>"New Application Form",'href'=>$form));
            $tab1 .= get_string('application', 'local_delegate');
        $tab1 .= html_writer::end_tag('a');

    $tab1 .= html_writer::end_tag('li');
$tab1 .= html_writer::end_tag('ul');

   



echo $OUTPUT->header();
echo $tab1;
echo html_writer::table($table);
echo $OUTPUT->footer();

 