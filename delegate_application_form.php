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
defined('MOODLE_INTERNAL') || die;

class delegate_application_form extends moodleform {
    public function definition() {
        $mform = $this->_form;
        $coursenames = array();
        if (isset($this->_customdata) && !empty($this->_customdata)){
            $id = $this->_customdata['id'];
        
            $mform->addElement('hidden', 'id', $id);
            $mform->setType('id', PARAM_INT);
            $coursedetails = get_course($id);
            $mform->addElement('static', 'courses1', get_string('courses', 'local_delegate'), $coursedetails->fullname);
            $delegetees = get_users_by_capability(context_course::instance($coursedetails->id), 'moodle/course:manageactivities', 'u.id, u.firstname, u.lastname');
            print_r($delegetees); die;
        } else {
            $allcourses = get_courses();
            $options = array(                                         
            'multiple' => true,                                                  
            'noselectionstring' => get_string('select_and_search', 'local_delegate')
            );  
            foreach ($allcourses as $courseid => $allcourse) {
                if($courseid>1){
                    $coursenames[$allcourse->id] = $allcourse->fullname;
                }                                                        
            }  
            $mform->addElement('autocomplete', 'courses', get_string('courses', 'local_delegate'), $coursenames, $options);
            $mform->addRule('courses', get_string('required'), 'required');
        }
        //Delegatee search and select
        $alladmins = get_admins();
        //echo '<pre>',print_r($alladmins),'</pre>';die;
        
        $delegatee = array();
        //$delegatee[0] = 'none';                                                                                                       
        foreach ($alladmins as $userid => $admin) {
            //echo '<pre>',print_r($admin),'</pre>';die;
            //$fullname = $admin->firstname . ' ' . $admin->lastname;                                                                          
            $delegatee[$admin->id] = fullname($admin);

            //$delegatee[$admin->id] = $fullname;                                                                
        }                                                                                                                           
        $options = array(                                                                                                           
            'multiple' => false,                                                  
            'noselectionstring' => get_string('select_and_search', 'local_delegate')                                                               
        );         
        $mform->addElement('autocomplete', 'delegatee', get_string('delegatee', 'local_delegate'), $delegatee, $options);
        $mform->addRule('delegatee', get_string('required'), 'required');

        
        $mform->addElement('date_selector', 'startdate', get_string('startdate', 'local_delegate'));
        $mform->setType('startdate', PARAM_INT);
        $mform->addRule('startdate', get_string('required'), 'required');


        $mform->addElement('date_selector', 'enddate', get_string('enddate', 'local_delegate'));
        $mform->setType('enddate', PARAM_INT);
        $mform->addRule('enddate', get_string('required'), 'required');


        $mform->addElement('textarea', 'reason', get_string('reason', 'local_delegate'));
        $mform->setType('reason', PARAM_TEXT);
       

        // Add form buttons
        $this->add_action_buttons(true, get_string('submit'));

        // Set form validation and definition
        $this->set_data($this->_customdata);
        $this->definition_after_data();
    }
    function validation($data, $files) {
        //print_r($data);die;
            $errors= array();

            if ($data["startdate"] >= $data["enddate"]){
               $errors['enddate'] = "End Date should be after Start Date "; 
            } 
            if ($data["startdate"] >= $data["enddate"]) {
               $errors['startdate'] = "Start Date should be before End Date ";
            } 
            return $errors;
    }

}


