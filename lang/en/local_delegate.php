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
 * Language
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['replacement_teacher'] = 'Replacement Teacher';
$string['pluginname'] = 'Delegate Application';
$string['delegate_application'] = 'delegate Applications';

// Form labels
$string['delegatee'] = 'Delegatee Name';
$string['startdate'] = 'Start Date';
$string['enddate'] = 'End Date';
$string['reason'] = 'Reason';
$string['courses'] = 'Select Courses';
$string['select_and_search'] = 'Search and Select';


// Form validation messages
$string['required'] = 'This field is required';

// Form submission
$string['submit'] = 'Submit';
$string['delegate_application_submitted'] = 'delegate application submitted successfully';
//Delegate Request
$string['courses'] = 'Courses';
$string['delegatee'] = 'Delegatee';
$string['start_date'] = 'Start Date';
$string['end_date'] = 'End Date';
$string['apply_date_time'] = 'Apply Date & Time';
$string['approved_by'] = 'Approved By';
$string['approved_date'] = 'Apporve Date';
$string['action'] = 'Action';
$string['staus'] = 'Staus';
$string['application'] = 'New Application for Delegate';
$string['allaap'] = 'All Application List';

$string['delegate:create'] = 'Create Delegation';
$string['delegate:view'] = 'View Delegation';
$string['delegate:approve'] = 'Approve Delegation';

$string['applystr'] = 'Create Application For Delegate';
$string['messageprovider:confirmation'] = 'Confirmation of your delegate submissions';
$string['messageprovider:submission'] = 'Notification of delegate request Approval or Decline';

$string['delegatedetails'] = 'Delegate Details';
$string['approve'] = 'Approve';
$string['decline'] = 'Decline';

$string['pending'] = 'Pending';
$string['approved'] = 'Approved';
$string['declined'] = 'Declined';

$string['delegatedetails'] = 'Delegate Details';

$string['approvestr'] = 'Confirm! Do You Want To Approve This Request?';
$string['declinestr'] = 'Confirm ! Do You Want To Decline This Request?';
$string['deletestr'] = 'Confirm ! Do You Want To Delete This Request?';
$string['delegatereq'] = 'Details of Delegate Request';
$string['delegatereqlist'] = 'Delegation Request List';

$string['enddatevalid'] = 'End Date should be after Start Date.';
$string['startdatevalid'] = 'End Date should be after Start Date.';

$string['submission_notice_subject'] = 'New Delegate Application';
$string['submission_notice_body'] = 
'<p>Hi {$a->touser}</p>
<p>{$a->fromuser} submits a delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a>.</p>
<p>The Delegatee name is {$a->fromuser}</p>
<p>To approve or decline please <a href = "{$a->link}" target = "_blank">click here</a>.</p>
<p>Thanks!</p>
';

$string['approve_notice_subject'] = 'Approve Delegate Application';
$string['approve_notice_body'] = 
'<p>Hi {$a->touser}</p>
<p>{$a->fromuser} submits a delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a>.</p>
<p>The Delegatee name is {$a->fromuser}</p>
<p>To approve or decline please <a href = "{$a->link}" target = "_blank">click here</a>.</p>
<p>Thanks!</p>
';

$string['decline_notice_subject'] = 'Decline Delegate Application';
$string['decline_notice_body'] = 
'<p>Hi {$a->touser}</p>
<p>{$a->fromuser} submits a delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a>.</p>
<p>The Delegatee name is {$a->fromuser}</p>
<p>To approve or decline please <a href = "{$a->link}" target = "_blank">click here</a>.</p>
<p>Thanks!</p>
';
