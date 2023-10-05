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
$string['delegate_application'] = 'Delegate Applications';
$string['newapplform'] = 'New Application Form';
// Form labels.
$string['delegatee'] = 'Delegatee Name';
$string['startdate'] = 'Start Date';
$string['enddate'] = 'End Date';
$string['reason'] = 'Reason';
$string['courses'] = 'Select Courses';
$string['select_and_search'] = 'Search and Select';
// Form validation messages.
$string['required'] = 'This field is required';
// Form submission.
$string['submit'] = 'Submit';
$string['delegate_application_submitted'] = 'delegate application submitted successfully';
// Delegate Request.
$string['decline'] = 'Decline';
$string['approve'] = 'Approve';
$string['edit'] = 'Edit';
$string['details'] = 'Details';
$string['delete'] = 'Delete';
$string['applicant'] = 'Applicant';
$string['applicantname'] = 'Applicant Name';
$string['rownumber'] = 'No.';
$string['courses'] = 'Courses';
$string['delegatee'] = 'Delegatee';
$string['delegator'] = 'Delegator';
$string['start_date'] = 'Start Date';
$string['end_date'] = 'End Date';
$string['apply_date_time'] = 'Apply Date & Time';
$string['approved_by'] = 'Approved By';
$string['approved_date'] = 'Apporve Date';
$string['action'] = 'Action';
$string['staus'] = 'Staus';
$string['application'] = 'New Application for Delegate';
$string['allaap'] = 'All Application List';
$string['delegate:create'] = 'Create Delegate Application';
$string['delegate:view'] = 'View Delegate Application';
$string['delegate:approve'] = 'Approve Delegate Application';
$string['applystr'] = 'Create Application For Delegate';
$string['messageprovider:confirmation'] = 'Confirmation of your delegate submissions';
$string['messageprovider:submission'] = 'Notification of delegate request Approval or Decline';
$string['messageprovider:confirmationdelegatee'] = 'Notification of approved delegate request to Delegatee';
$string['delegate:emailnotifysubmission'] = 'Submission Notification';
$string['delegate:delegateeapprovemail'] = 'Delegatee Approve Notification';
$string['delegate:emailconfirmsubmission'] = 'Confirm Submission Notification';
$string['delegate:approve'] = 'Approve Delegation Request';
$string['delegate:update'] = 'Update Delegate Application';
$string['delegate:delete'] = 'Update Delegate Application';
$string['delegate:decline'] = 'Decline Delegation Request';
$string['delegatedetails'] = 'Delegate Details';
$string['approve'] = 'Approve';
$string['decline'] = 'Decline';
$string['pending'] = 'Pending';
$string['dotpending'] = '............Pending';
$string['approved'] = 'Approved';
$string['declined'] = 'Declined';
$string['delegatedetails'] = 'Delegate Details';
$string['approvestr'] = 'Confirm! Do You Want To Approve This Request?';
$string['declinestr'] = 'Confirm ! Do You Want To Decline This Request?';
$string['deletestr'] = 'Confirm ! Do You Want To Delete This Request?';
$string['delegatereq'] = 'Details of Delegate Request';
$string['delegatereqlist'] = 'Delegation Request List';
$string['enddatevalid'] = 'End-Date must be dated after Start-Date.';
$string['startdatevalid'] = 'Start-Date must be dated before End-Date.';
// Submission.
$string['submission_notice_subject'] = 'New Delegate Application';
$string['submission_notice_body'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->delegator} submits a delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a>.</p>
<p>The Delegatee name is {$a->delegatee}</p>
<p>To approve or decline please <a href = "{$a->link}" target = "_blank">click here</a>.</p>
<p>Thanks!</p>
';
// Confirmation.
$string['approve_notice_subject_delegator'] = 'Approve Delegate Application';
$string['approve_notice_body_delegator'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->fromuser} approved your delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The Delegatee name is {$a->delegatee}</p>
<p>Welcome!</p>
';
// Confirmationdelegatee.
$string['approve_notice_subject_delegatee'] = 'Approve Delegate Application';
$string['approve_notice_body_delegatee'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->fromuser} approved you as delegatee for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The Delegator name is {$a->delegator}</p>
<p>Thank You!</p>
';
$string['decline_notice_subject'] = 'Decline Delegate Application';
$string['decline_notice_body'] =
 '<p>Hi {$a->delegator}</p>
<p>{$a->admin} declined your delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The Delegatee name was {$a->delegatee}</p>
<p>Sorry!</p>
';
