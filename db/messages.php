<?php
defined('MOODLE_INTERNAL') || die();
$messageproviders = array (
    // Notify teacher that a student has submitted a quiz attempt
    'submission' => array (
        'defaults' => [
            'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN + MESSAGE_DEFAULT_LOGGEDOFF,
            'email' => MESSAGE_PERMITTED 
        ],
        'capability'  => 'local/delegate:emailnotifysubmission'
    ),
    // Confirm a student's quiz attempt
    'confirmation' => array (
        'defaults' => [
            'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN + MESSAGE_DEFAULT_LOGGEDOFF,
            'email' => MESSAGE_PERMITTED 
        ],
        'capability'  => 'local/delegate:emailconfirmsubmission'
    )
);