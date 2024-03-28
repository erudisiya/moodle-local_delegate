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
defined('MOODLE_INTERNAL') || die();
use \core_privacy\local\metadata\collection;
use \core_privacy\local\request\contextlist;
use \core_privacy\local\request\writer;
use \core_privacy\local\request\approved_contextlist;

use \core_privacy\local\request\userlist;
use \core_privacy\local\request\approved_userlist;
use \core_privacy\manager;

class provider implements
    // This plugin does not store any personal user data.
    \core_privacy\local\metadata\provider,
    // This plugin is a core_user_data_provider.
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\core_userlist_provider{

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

        if (!$context instanceof \context_course) {
            return;
        }

        // Fetch all choice answers.
        $sql = "SELECT ca.userid
                  FROM {course_modules} cm
                  JOIN {modules} m ON m.id = cm.module AND m.name = :modname
                  JOIN {choice} ch ON ch.id = cm.instance
                  JOIN {choice_options} co ON co.choiceid = ch.id
                  JOIN {choice_answers} ca ON ca.optionid = co.id AND ca.choiceid = ch.id
                 WHERE cm.id = :cmid";

        $params = [
            'cmid'      => $context->instanceid,
            'modname'   => 'choice',
        ];

        $userlist->add_from_sql('userid', $sql, $params);

    }
    /**
     * Export all user data for the specified user, in the specified contexts, using the supplied exporter instance.
     *
     * @param   approved_contextlist    $contextlist    The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {}
    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;
    }
    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context the context to delete in.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if (!$context instanceof \context_course) {
            return;
        }

        /*if ($cm = get_coursemodule_from_id('choice', $context->instanceid)) {
            $DB->delete_records('choice_answers', ['choiceid' => $cm->instance]);
        }*/
    }
    public static function get_contexts_for_userid(int $userid) : contextlist {}
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
    }
}