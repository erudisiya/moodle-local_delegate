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
 * lib
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function local_delegate_extend_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE;
    // Only add this settings item on non-site course pages.
    if (!$PAGE->course || $PAGE->course->id == 1) {
        return;
    }

    // Only let users with the appropriate capability see this settings item.
    if (!has_capability('local/delegate:view', context_course::instance($PAGE->course->id))) {
        return;
    }

    if ($settingnode = $settingsnav->find('courseadmin',
         navigation_node::TYPE_COURSE)) {
        $strfoo = get_string('pluginname', 'local_delegate');
        $url = new moodle_url('/local/delegate/list.php', array('courseid' => $PAGE->course->id));
        $foonode = navigation_node::create(
            $strfoo,
            $url,
            navigation_node::NODETYPE_LEAF,
            'delegate',
            'delegate',
            new pix_icon('t/addcontact', $strfoo)
        );
        if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            $foonode->make_active();
        }
        $settingnode->add_node($foonode);
    }
}
function local_delegate_get($id) {
    GLOBAL $DB;
    $delegate = $DB->get_record('local_delegate', array('id' => $id));
    return $delegate;
}
function local_delegate_send_notification($delegate) {
    GLOBAL $CFG;
    $touser = get_admin();
    $formuser = core_user::get_user($delegate->delegator);
    $delegateename = core_user::get_user($delegate->delegatee);
    $course = get_course($delegate->courses);
    $delegatedetailsurl = $CFG->wwwroot.'/local/delegate/details.php?id='.$delegate->id;
    $courseurl = $CFG->wwwroot.'/course/view.php?id='.$course->id;
    $strreplace = ['touser' => fullname($touser),
     'delegator' => fullname($formuser), 'delegatee' => fullname($delegateename),
      'course' => $course->fullname, 'courseurl' => $courseurl, 'link' => $delegatedetailsurl];
    $message = new \core\message\message();
    $message->component = 'local_delegate'; // Your plugin's name.
    $message->name = 'submission'; // Your notification name from message.php.
    $message->userfrom = core_user::get_noreply_user(); // If the message is 'from' a specific user you can set them here.
    $message->userto = $touser;
    $message->subject = get_string('submission_notice_subject', 'local_delegate');
    $message->fullmessage = get_string('submission_notice_body', 'local_delegate', $strreplace);
    $message->fullmessageformat = FORMAT_MARKDOWN;
    $message->fullmessagehtml = get_string('submission_notice_body', 'local_delegate', $strreplace);
    $message->smallmessage = get_string('submission_notice_subject', 'local_delegate');
    $message->notification = 1; // Because this is a notification generated from Moodle, not a user-to-user message.
    $message->contexturl = (new \moodle_url('/course/'))->out(false); // A relevant URL for the notification.
    $message->contexturlname = 'abcd'; // Link title explaining where users get to for the contexturl.
    $content = array('*' => array('header' => '  ', 'footer' => '  ')); // Extra content for specific processor.
    $message->set_additional_content('email', $content);
    // Actually send the message.
    $messageid = message_send($message);
    return;
}
function local_delegate_approve_notification($delegate) {
    GLOBAL $CFG;
    $touser = core_user::get_user($delegate->delegator);
    $formuser = get_admin();
    $course = get_course($delegate->courses);
    $delegateename = core_user::get_user($delegate->delegatee);
    $delegatedetailsurl = $CFG->wwwroot.'/local/delegate/details.php?id='.$delegate->id;
    $courseurl = $CFG->wwwroot.'/course/view.php?id='.$course->id;
    $strreplace = ['touser' => fullname($touser),
     'fromuser' => fullname($formuser), 'course' => $course->fullname, 'courseurl' => $courseurl,
     'link' => $delegatedetailsurl, 'delegatee' => fullname($delegateename),
      'start_date' => date('d-M-Y', $delegate->start_date), 'end_date' => date('d-M-Y', $delegate->end_date)];

    $message = new \core\message\message();
    $message->component = 'local_delegate'; // Your plugin's name.
    $message->name = 'confirmation'; // Your notification name from message.php.
    $message->userfrom = core_user::get_noreply_user(); // If the message is 'from' a specific user you can set them here.
    $message->userto = $touser;
    $message->subject = get_string('approve_notice_subject_delegator', 'local_delegate');
    $message->fullmessage = get_string('approve_notice_body_delegator', 'local_delegate', $strreplace);
    $message->fullmessageformat = FORMAT_MARKDOWN;
    $message->fullmessagehtml = get_string('approve_notice_body_delegator', 'local_delegate', $strreplace);
    $message->smallmessage = get_string('approve_notice_subject_delegator', 'local_delegate');
    $message->notification = 1; // Because this is a notification generated from Moodle, not a user-to-user message.

    $content = array('*' => array('header' => '  ', 'footer' => '  ')); // Extra content for specific processor.
    $message->set_additional_content('email', $content);
    // Actually send the message.
    $messageid = message_send($message);
    return;
}

function local_delegate_decline_notification($delegate) {
    GLOBAL $CFG;
    $delegator = core_user::get_user($delegate->delegator);
    $delegateename = core_user::get_user($delegate->delegatee);
    $formuser = get_admin();
    $course = get_course($delegate->courses);
    $delegatedetailsurl = $CFG->wwwroot.'/local/delegate/details.php?id='.$delegate->id;
    $courseurl = $CFG->wwwroot.'/course/view.php?id='.$course->id;
    $strreplace = ['delegator' => fullname($delegator), 'admin' => fullname($formuser),
     'course' => $course->fullname, 'courseurl' => $courseurl, 'link' => $delegatedetailsurl,
      'delegatee' => fullname($delegateename), 'start_date' => date('d-M-Y', $delegate->start_date),
       'end_date' => date('d-M-Y', $delegate->end_date)];
    $message = new \core\message\message();
    $message->component = 'local_delegate'; // Your plugin's name.
    $message->name = 'confirmation'; // Your notification name from message.php.
    $message->userfrom = core_user::get_noreply_user(); // If the message is 'from' a specific user you can set them here.
    $message->userto = $delegator;
    $message->subject = get_string('decline_notice_subject', 'local_delegate');
    $message->fullmessage = get_string('decline_notice_body', 'local_delegate', $strreplace);
    $message->fullmessageformat = FORMAT_MARKDOWN;
    $message->fullmessagehtml = get_string('decline_notice_body', 'local_delegate', $strreplace);
    $message->smallmessage = get_string('decline_notice_subject', 'local_delegate');
    $message->notification = 1; // Because this is a notification generated from Moodle, not a user-to-user message.
    $message->contexturl = (new \moodle_url('/course/'))->out(false); // A relevant URL for the notification.
    $message->contexturlname = 'xyz'; // Link title explaining where users get to for the contexturl.
    $content = array('*' => array('header' => '  ', 'footer' => '  ')); // Extra content for specific processor.
    $message->set_additional_content('email', $content);
    // Actually send the message.
    $messageid = message_send($message);
    return;
}
function local_delegate_approve_notification_delegatee($delegate) {
    GLOBAL $CFG;
    $delegatorfullname = core_user::get_user($delegate->delegator);
    $touser = core_user::get_user($delegate->delegatee);
    $formuser = get_admin();
    $course = get_course($delegate->courses);
    $delegatedetailsurl = $CFG->wwwroot.'/local/delegate/details.php?id='.$delegate->id;
    $courseurl = $CFG->wwwroot.'/course/view.php?id='.$course->id;
    $strreplace = ['touser' => fullname($touser),
     'fromuser' => fullname($formuser), 'course' => $course->fullname, 'courseurl' => $courseurl,
     'link' => $delegatedetailsurl, 'delegator' => fullname($delegatorfullname),
      'start_date' => date('d-M-Y', $delegate->start_date), 'end_date' => date('d-M-Y', $delegate->end_date)];
    $message = new \core\message\message();
    $message->component = 'local_delegate'; // Your plugin's name.
    $message->name = 'confirmationdelegatee'; // Your notification name from message.php.
    $message->userfrom = core_user::get_noreply_user(); // If the message is 'from' a specific user you can set them here.
    $message->userto = $touser;
    $message->subject = get_string('approve_notice_subject_delegatee', 'local_delegate');
    $message->fullmessage = get_string('approve_notice_body_delegatee', 'local_delegate', $strreplace);
    $message->fullmessageformat = FORMAT_MARKDOWN;
    $message->fullmessagehtml = get_string('approve_notice_body_delegatee', 'local_delegate', $strreplace);
    $message->smallmessage = get_string('approve_notice_body_delegatee', 'local_delegate');
    $message->notification = 1; // Because this is a notification generated from Moodle, not a user-to-user message.

    $content = array('*' => array('header' => '  ', 'footer' => '  ')); // Extra content for specific processor.
    $message->set_additional_content('email', $content);
    // Actually send the message.
    $messageid = message_send($message);
    return;
}
