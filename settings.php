<?php
/**
 * Flutterwave enrolments plugin settings and presets.
 *
 * @package    enrol_flutterwave
 * @copyright  2020 Jay
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Settings.
    $settings->add(new admin_setting_heading('enrol_flutterwave_settings', '',
                   get_string('pluginname_desc', 'enrol_flutterwave')));
    $settings->add(new admin_setting_configtext('enrol_flutterwave/pubKey',
                   get_string('pubKey', 'enrol_flutterwave'),
                   'Paste Payment Public Key here', '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('enrol_flutterwave/email',
                   get_string('email', 'enrol_flutterwave'),
                   'Email Address', '', PARAM_RAW));
    /* 
    $settings->add(new admin_setting_configcheckbox('enrol_flutterwave/checkproductionmode',
                   get_string('checkproductionmode', 'enrol_flutterwave'), '', 0));
    $settings->add(new admin_setting_configcheckbox('enrol_flutterwave/mailstudents',
                   get_string('mailstudents', 'enrol_flutterwave'), '', 0));
    $settings->add(new admin_setting_configcheckbox('enrol_flutterwave/mailteachers',
                   get_string('mailteachers', 'enrol_flutterwave'), '', 0));
    $settings->add(new admin_setting_configcheckbox('enrol_flutterwave/mailadmins',
      get_string('mailadmins', 'enrol_flutterwave'), '', 0));
     */

    // Note: let's reuse the ext sync constants and strings here, internally it is very similar,
    //       it describes what should happen when users are not supposed to be enrolled any more.
    $options = array(
        ENROL_EXT_REMOVED_KEEP           => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'),
        ENROL_EXT_REMOVED_UNENROL        => get_string('extremovedunenrol', 'enrol'),
    );
    $settings->add(new admin_setting_configselect('enrol_flutterwave/expiredaction',
                   get_string('expiredaction', 'enrol_flutterwave'),
                   get_string('expiredaction_help', 'enrol_flutterwave'), ENROL_EXT_REMOVED_SUSPENDNOROLES, $options));

    // Enrol instance defaults.
    $settings->add(new admin_setting_heading('enrol_flutterwave_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_flutterwave/status',
                   get_string('status', 'enrol_flutterwave'),
                   get_string('status_desc', 'enrol_flutterwave'), ENROL_INSTANCE_DISABLED, $options));

    $settings->add(new admin_setting_configtext('enrol_flutterwave/cost',
                   get_string('cost', 'enrol_flutterwave'), '', 0, PARAM_FLOAT, 4));

    $currencies = enrol_get_plugin('flutterwave')->get_currencies();
    $settings->add(new admin_setting_configselect('enrol_flutterwave/currency',
    get_string('currency', 'enrol_flutterwave'), '', 'GHS', $currencies));
    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(new admin_setting_configselect('enrol_flutterwave/roleid',
                       get_string('defaultrole', 'enrol_flutterwave'),
                       get_string('defaultrole_desc', 'enrol_flutterwave'), $student->id, $options));
    }

    $settings->add(new admin_setting_configduration('enrol_flutterwave/enrolperiod',
        get_string('enrolperiod', 'enrol_flutterwave'), get_string('enrolperiod_desc', 'enrol_flutterwave'), 0));
}
