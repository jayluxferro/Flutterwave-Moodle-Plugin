### Enrolment in Moodle using Flutterwave payment gateway for paid courses.

This plugin helps admins and web admins use Flutterwave as the payment gateway.

#### Installation Guidance

Log in to your moodle site as an "admin user" and follow the following steps:

1. Download the plugin (https://github.com/jayluxferro/Flutterwave-Moodle-Plugin/releases) as a ZIP package. Upload the zip package from Site Administration > Plugins -> Install Plugins. Choose Plugin type. Upload the ZIP package, check the acknowledgement and install.

2. Go to Plugins -> Enrolments -> Manage enrol plugins -> Enable 'flutterwave' from list.

3. Click 'Settings' which will lead to the settings page of the plugin.

4. Provide merchant public key for Flutterwave, select the checkbox as per requirement. Save the settings.

5. Select any course from course listing page.

6. Go to Course Administration -> Users -> Enrolment Methods -> Add method 'flutterwave' from the dropdown. Set 'Custom instance name', 'Enrol cost' etc and add the method.

This completes all the steps for the administrator's end. Now registered users can login to the Moodle site and view the course after a successful payment.

#### Flutterwave Configuration
Enable *V3 Webhooks* in your flutterwave settings and also the preferred payment methods.

#### Payment Demonstration
https://youtu.be/4xw4dimDa5k
