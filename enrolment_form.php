<?php
require_once("lib.php");
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

require_login();

global $DB, $CFG;
$amount = $cost;
$publicKey = $this->get_config('pubKey');
$mail = $this->get_config('email');
if(!isset($mail) || $mail == ''){
  $mail = 'devteam@sperixlabs.org';
}
?>
<!-- pay now -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <div style="text-align: center" id="raveView">
  <form>
      <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
      <button type="button" onClick="payWithRave()">
      <img src="<?php echo $CFG->wwwroot; ?>/enrol/flutterwave/pix/paynow.png" style="width: 80%; height: 'auto'; padding: 10px;">
      </button>
  </form>
</div>

<form method="post" action="#" id="submitForm">
  <input type="hidden" name="responseData" id="responseData" value=""/>
</form>

<div id="loaderView" style="text-align: center;">
  <img style="width: 50px;" src="<?php echo $CFG->wwwroot; ?>/enrol/flutterwave/pix/loader.gif"/>
</div>

<?php
    if(isset($_POST['responseData'])){
      $data = json_decode($_POST['responseData'], true);
      $paid_amount = $data['amount'];
      $app_fee = $data['appfee'];
      $payment_status = $data['status']; // successful
      $response_code = (int)$data['chargeResponseCode'];
      $response_reason_code = $response_code;
      $response_reason_text = $data['chargeResponseMessage'];
      $auth_mode = $data['authModelUsed'];
      $trans_id = $data['id'];
      $method = $data['paymentType'];
      $account_number = $data['raveRef'];
      $full_name = $data['customer']['fullName'];
      $phone = $data['customer']['phone'];
      $email = $data['customer']['email'];
      $order_ref = $data['orderRef'];
      $flw_ref = $data['flwRef'];
      $currency = $data['currency'];
      $tx_ref = $data['txRef'];
      
      $enrolflutterwave = new stdClass();
      $enrolflutterwave->amount = $paid_amount;
      $enrolflutterwave->app_fee = $app_fee;
      $enrolflutterwave->payment_status = $payment_status;
      $enrolflutterwave->response_code = $response_code;
      $enrolflutterwave->response_reason_code = $response_reason_code;
      $enrolflutterwave->response_reason_text = $response_reason_text;
      $enrolflutterwave->auth_mode = $auth_mode;
      $enrolflutterwave->trans_id = $trans_id;
      $enrolflutterwave->method = $method;
      $enrolflutterwave->account_number = $account_number;
      $enrolflutterwave->full_name = $full_name;
      $enrolflutterwave->phone = $phone;
      $enrolflutterwave->email = $email;
      $enrolflutterwave->order_ref = $order_ref;
      $enrolflutterwave->flw_ref = $flw_ref;
      $enrolflutterwave->currency = $currency;
      $enrolflutterwave->tx_ref = $tx_ref;
      $enrolflutterwave->timeupdated = time();
      $enrolflutterwave->courseid = $instance->courseid;
      $enrolflutterwave->userid = $USER->id;
      $enrolflutterwave->item_name = $coursefullname;
      $enrolflutterwave->instanceid = $instance->id;

      $ret1 = $DB->insert_record("enrol_flutterwave", $enrolflutterwave, true);

      // try and enrol student
      if (! $plugininstance = $DB->get_record("enrol", array("id" => $instance->id, "status" => 0))) {
        echo "
          <script>
              document.getElementById('loaderView').style.display = 'none'
          </script>
        ";
        print_error("Not a valid instance id"); die;
      }
      
      if ($plugininstance->enrolperiod) {
         $timestart = time();
         $timeend   = $timestart + $plugin_instance->enrolperiod;
      } else {
          $timestart = 0;
          $timeend   = 0;
      }
      $plugin = enrol_get_plugin('flutterwave');
      /* Enrol User */
      if((float) $paid_amount >= (float) $cost){
        $plugin->enrol_user($plugininstance, $USER->id, $plugininstance->roleid, $timestart, $timeend);
        echo "<script type='text/javascript'>
                swal('Success', 'Payment successful', 'success');
               window.location.href='.$CFG->wwwroot.'/course/view.php?id='. $instance->courseid;
               </script>";
      }else{
        echo "<script type='text/javascript'>
                swal('Error', 'Payment failed. Try again!', 'error');
               </script>";
      }
    }
?>


<script>
  // hiding loaderView
  document.getElementById('loaderView').style.display = 'none'
  
  function payWithRave() {
    const url = window.location.href
    

    var x = getpaidSetup({
        PBFPubKey: '<?php echo $publicKey; ?>',
        customer_email: "<?php echo $mail; ?>",
        amount: <?php echo $amount; ?>,
        currency: "<?php echo $instance->currency; ?>",
        txref: new Date().getTime().toString(),
        onclose: function() {
          setTimeout( () => window.location.assign(url), 1000)
        },
        callback: function(response) {
          //console.log(response)
          //setTimeout( () =>  { x.close(); window.location.assign(url) }, 1000)
          // hide raveView
          document.getElementById('raveView').style.display = 'none'

          // show loaderView
          document.getElementById('loaderView').style.display = 'block'
          
          if (
              response.data.respcode == "00" ||
              response.data.respcode == "0"
          ) {
              // redirect to a success page
                document.getElementById('responseData').value = JSON.stringify(response.tx)
                document.getElementById('submitForm').submit()
          } else {
              // redirect to a failure page.
              swal('Error', 'Payment failed. Please try again', 'error');
              setTimeout(() => window.location.assign(window.location.href), 3000)
          }
          x.close() 
        }
    });
  }
</script>
