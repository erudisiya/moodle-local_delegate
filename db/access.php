<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    // Capability to access the leave application form.
    'local/delegate_application:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
        ),
    ),

    // Capability to assign replacement teachers.
    'local/delegate_application:create' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ),
    ),

    // Capability to approve leave applications.
    'local/delegate_application:approve' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        ),
    ),

);

