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
$string['replacement_teacher'] = 'Replacement teacher';
$string['pluginname'] = 'Delegate application';
$string['delegate_application'] = 'Delegate applications';
$string['newapplform'] = 'New application form';
// Form labels.
$string['delegatee'] = 'Delegatee name';
$string['startdate'] = 'Start date';
$string['enddate'] = 'End date';
$string['reason'] = 'Reason';
$string['courses'] = 'Select courses';
$string['select_and_search'] = 'Search and select';
// Form validation messages.
$string['required'] = 'This field is required';
// Form submission.
$string['submit'] = 'Submit';
$string['delegate_application_submitted'] = 'Delegate application submitted successfully';
// Delegate Request.
$string['decline'] = 'Decline';
$string['approve'] = 'Approve';
$string['edit'] = 'Edit';
$string['details'] = 'Details';
$string['delete'] = 'Delete';
$string['applicant'] = 'Applicant';
$string['applicantname'] = 'Applicant name';
$string['rownumber'] = 'No.';
$string['courses'] = 'Courses';
$string['delegatee'] = 'Delegatee';
$string['delegator'] = 'Delegator';
$string['start_date'] = 'Start Date';
$string['end_date'] = 'End Date';
$string['apply_date_time'] = 'Apply date & time';
$string['approved_by'] = 'Approved by';
$string['approved_date'] = 'Apporve date';
$string['action'] = 'Action';
$string['staus'] = 'Staus';
$string['application'] = 'New application for delegate';
$string['allaap'] = 'All application list';
$string['delegate:create'] = 'Create delegate application';
$string['delegate:view'] = 'View delegate application';
$string['delegate:approve'] = 'Approve delegate application';
$string['applystr'] = 'Create application for delegate';
$string['messageprovider:confirmation'] = 'Confirmation of your delegate submissions';
$string['messageprovider:submission'] = 'Notification of delegate request approval or decline';
$string['messageprovider:confirmationdelegatee'] = 'Notification of approved delegate request to delegatee';
$string['delegate:emailnotifysubmission'] = 'Submission notification';
$string['delegate:delegateeapprovemail'] = 'Delegatee approve notification';
$string['delegate:emailconfirmsubmission'] = 'Confirm submission notification';
$string['delegate:approve'] = 'Approve delegation request';
$string['delegate:update'] = 'Update delegate application';
$string['delegate:delete'] = 'Update delegate application';
$string['delegate:decline'] = 'Decline delegation request';
$string['delegatedetails'] = 'Delegate details';
$string['approve'] = 'Approve';
$string['decline'] = 'Decline';
$string['pending'] = 'Pending';
$string['dotpending'] = '............Pending';
$string['approved'] = 'Approved';
$string['declined'] = 'Declined';
$string['delegatedetails'] = 'Delegate details';
$string['approvestr'] = 'Confirm! do you want to approve this request?';
$string['declinestr'] = 'Confirm ! do you want to decline this request?';
$string['deletestr'] = 'Confirm ! do you want to delete this request?';
$string['delegatereq'] = 'Details of delegate request';
$string['delegatereqlist'] = 'Delegation request list';
$string['enddatevalid'] = 'End date must be dated after start date.';
$string['startdatevalid'] = 'Start date must be dated before end date.';
// Submission.
$string['submission_notice_subject'] = 'New delegate application';
$string['submission_notice_body'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->delegator} submits a delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a>.</p>
<p>The delegatee name is {$a->delegatee}</p>
<p>To approve or decline please <a href = "{$a->link}" target = "_blank">click here</a>.</p>
<p>thanks!</p>
';
// Confirmation.
$string['approve_notice_subject_delegator'] = 'Approve delegate application';
$string['approve_notice_body_delegator'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->fromuser} approved your delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The delegatee name is {$a->delegatee}</p>
<p>welcome!</p>
';
// Confirmationdelegatee.
$string['approve_notice_subject_delegatee'] = 'Approve delegate application';
$string['approve_notice_body_delegatee'] =
 '<p>Hi {$a->touser}</p>
<p>{$a->fromuser} approved you as delegatee for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The delegator name is {$a->delegator}</p>
<p>thank You!</p>
';
$string['decline_notice_subject'] = 'Decline delegate application';
$string['decline_notice_body'] =
 '<p>Hi {$a->delegator}</p>
<p>{$a->admin} declined your delegate application for course <a href = "{$a->courseurl}" target = "_blank">{$a->course}</a> {$a->start_date} to {$a->end_date}.</p>
<p>The delegatee name was {$a->delegatee}</p>
<p>sorry!</p>
';

$string['privacy:metadata:local_delegate'] = 'Information about the delegate to the responsibility to a delegatee depends on admin approval.';
$string['privacy:metadata:local_delegate:delegator'] = 'The ID of the user who is delegator.';
$string['privacy:metadata:local_delegate:delegatee'] = 'The ID of the user who is delegatee.';
$string['privacy:metadata:local_delegate:start_date'] = 'The start time of the delegation request.';
$string['privacy:metadata:local_delegate:end_date'] = 'The end time of the delegation request.';

$string['privacy:metadata:local_delegate:created_by'] = 'The ID of the user who creates the delegation request.';
$string['privacy:metadata:local_delegate:apply_date_time'] = 'The time of the creation of delegation request.';
$string['privacy:metadata:local_delegate:modifyed_by'] = 'The ID of the user who modifies the delegation request.';
$string['privacy:metadata:local_delegate:modify_datetime'] = 'The time of the modification of delegation request.';
$string['privacy:metadata:local_delegate:approved_by'] = 'The ID of the user who is approve the delegation request.';
$string['privacy:metadata:local_delegate:approved_date'] = 'The date of approval of the delegation request.';
