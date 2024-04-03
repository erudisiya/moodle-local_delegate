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
 * Delegate Application privacy provider
 *
 * @package   local_delegate
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html +GNU GPL v3 or later
 */

namespace local_delegate\privacy;
use core_privacy\local\metadata\collection;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\writer;
use core_privacy\local\request\approved_contextlist;

use core_privacy\local\request\userlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\manager;

class provider implements
    // This plugin does not store any personal user data.
    \core_privacy\local\metadata\provider,
    // This plugin is a core_user_data_provider.
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\core_userlist_provider {
    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
        'local_delegate',
        [
            'delegator' => 'privacy:metadata:local_delegate:delegator',
            'delegatee' => 'privacy:metadata:local_delegate:delegatee',
            'start_date' => 'privacy:metadata:local_delegate:start_date',
            'end_date' => 'privacy:metadata:local_delegate:end_date',

            'created_by' => 'privacy:metadata:local_delegate:created_by',
            'apply_date_time' => 'privacy:metadata:local_delegate:apply_date_time',
            'modifyed_by' => 'privacy:metadata:local_delegate:modifyed_by',
            'modify_datetime' => 'privacy:metadata:local_delegate:modify_datetime',
            'approved_by' => 'privacy:metadata:local_delegate:approved_by',
            'approved_date' => 'privacy:metadata:local_delegate:approved_date',

        ],
        'privacy:metadata:local_delegate'
        );
        return $collection;
    }
    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();
        if (!$context instanceof \context_system) {
            return;
        }
        $sql = 'SELECT DISTINCT delegator FROM {local_delegate}';
        $userlist->add_from_sql('userid', $sql, []);
    }
    /**
     * Get the lists of contexts that contain user information for the specified user.
     *
     * @param int $userid
     * @return contextlist
     */
    public static function get_contexts_for_userid(int $userid) : contextlist {
        $contextlist = new contextlist();
        // I know we should really provide the proper contexts.
        // This can be so messy, we just return system context. Payments should really be system context anyway.
        $contextlist->add_system_context();
        return $contextlist;
    }
    /**
     * Delete all use data which matches the specified context.
     *
     * @param context $context The module context.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;
        if ($context->contextlevel != CONTEXT_SYSTEM) {
            return;
        }
        // Delete everything.
        $DB->delete_records('local_delegate', null);
    }
    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
        if (empty($contextlist->count())) {
            return;
        }
        $user = $contextlist->get_user();
        foreach ($contextlist->get_contexts() as $context) {
            // Check that the context is a system context.
            if ($context->contextlevel != CONTEXT_SYSTEM) {
                continue;
            }
            $DB->delete_records_select('local_delegate', 'delegator = :delegator', ['delegator' => $user->id]);
        }
    }
    /**
     * Delete multiple users within a single context.
     *
     * @param  approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();
        if (!$context instanceof \context_system) {
            return;
        }
        $userids = $userlist->get_userids();
        list($usersql, $userparams) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
        $DB->delete_records_select('local_delegate', 'delegator '.$usersql, $userparams);
    }
    /**
     * Export all user data for the specified payment record, and the given context.
     *
     * @param \context $context Context
     * @param array $subcontext The location within the current context that the payment data belongs
     * @param \stdClass $payment The payment record
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;
        $user = $contextlist->get_user();
        $subcontext[] = get_string('pluginname', 'local_delegate');
        $record = $DB->get_record('local_delegate', ['delegator' => $user->id]);
        $data = (object) [
            'delegator' => $record->delegator,
            'delegatee' => $record->delegatee,
            'courses' => $record->courses,
            'reason' => $record->reason,
            'status' => $record->status,
        ];
        writer::with_context($context)->export_data(
            $subcontext,
            $data
        );
    }
}
