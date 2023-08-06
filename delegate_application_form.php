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
 * @copyright 2023 Sandipa Mukherjee {contact.erudisiya@gmail.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

class delegate_application_form extends moodleform {
    public function definition() {
        global $USER, $CFG;
        require_once($CFG->dirroot . '/local/delegate/lib.php');
        $delegatee = array();    
        $mform = $this->_form;
        $coursenames = array();
        if (isset($this->_customdata) && !empty($this->_customdata)){
            if (isset($this->_customdata['id'])) {
                $id = $this->_customdata['id'];//delegate id
            
                $mform->addElement('hidden', 'id', $id);
                $mform->setType('id', PARAM_INT);
            }
            if (isset($this->_customdata['courseid'])) {
                $courseid = $this->_customdata['courseid'];//courseid
                $mform->addElement('hidden', 'courseid', $courseid);
                $mform->setType('courseid', PARAM_INT);
            }
            
            
            $coursedetails = get_course($courseid);
            $mform->addElement('static', 'textcourses', get_string('courses', 'local_delegate'), $coursedetails->fullname);
            $delegetees = get_users_by_capability(context_course::instance($coursedetails->id), 'moodle/course:manageactivities', 'u.*');
                                                                                                            
            foreach ($delegetees as $userid => $delegete) {
                if($delegete->id !== $USER->id){

                    $delegatee[$delegete->id] = fullname($delegete);

                }                                             
            }
        } 
                                           
        $options = array(                                            
            'multiple' => false,                                                  
            'noselectionstring' => get_string('select_and_search', 'local_delegate')                                                               
        );         
        if ($id){
            $delegate = get_delegate($id);
            $delegateedetails = core_user::get_user($delegate->delegatee);
            $mform->addElement('static', 'textdelegatee', get_string('delegatee', 'local_delegate'), fullname($delegateedetails));
            $mform->addElement('hidden', 'delegatee', $id);
            $mform->setType('delegatee', PARAM_INT);
            
            
        } else {
            $mform->addElement('autocomplete', 'delegatee', get_string('delegatee', 'local_delegate'), $delegatee, $options);
            $mform->addRule('delegatee', get_string('required'), 'required');
        }
        
        $mform->addElement('date_selector', 'startdate', get_string('startdate', 'local_delegate'));
        $mform->setType('startdate', PARAM_INT);
        $mform->addRule('startdate', get_string('required'), 'required');


        $mform->addElement('date_selector', 'enddate', get_string('enddate', 'local_delegate'));
        $mform->setType('enddate', PARAM_INT);
        $mform->addRule('enddate', get_string('required'), 'required');


        $mform->addElement('textarea', 'reason', get_string('reason', 'local_delegate'));
        $mform->setType('reason', PARAM_TEXT);
        $mform->addRule('reason', get_string('required'), 'required');

        // Add form buttons
        $this->add_action_buttons(true, get_string('submit'));

        // Set form validation and definition
        $this->set_data($this->_customdata);
        $this->definition_after_data();
    }
    function validation($data, $files) {
        $errors= array();

        if ($data["startdate"] >= $data["enddate"]){
           $errors['enddate'] = get_string('enddatevalid', 'local_delegate'); 
        } 
        if ($data["startdate"] >= $data["enddate"]) {
           $errors['startdate'] = get_string('startdatevalid', 'local_delegate');
        } 
        return $errors;
    }

}


