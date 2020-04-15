<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(

  'enrol/flutterwave:config' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'manager' => CAP_ALLOW,
    )
  ),
  'enrol/flutterwave:manage' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'manager' => CAP_ALLOW,
      'editingteacher' => CAP_ALLOW,
    )
  ),
  'enrol/flutterwave:unenrol' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'manager' => CAP_ALLOW,
    )
  ),
  'enrol/flutterwave:unenrolself' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
    )
  ),
);
