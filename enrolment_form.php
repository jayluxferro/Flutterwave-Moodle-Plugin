<?php
$amount = $this->get_config('cost');
$publicKey = $this->get_config('pubKey');
?>
<!-- pay now -->
<div style="text-align: center">
  <form>
      <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
      <button type="button" onClick="payWithRave()">
      <img src="<?php echo $CFG->wwwroot; ?>/enrol/flutterwave/pix/paynow.png" style="width: 40%; height: 'auto'; padding: 10px;">
      </button>
  </form>
</div>


<script>
  function payWithRave() {
    const url = window.location.href

    var x = getpaidSetup({
        PBFPubKey: '<?php echo $publicKey; ?>',
        customer_email: "test_api@sperixlabs.org",
        amount: <?php echo $amount; ?>,
        currency: "<?php echo $instance->currency; ?>",
        //country: "GH",
        txref: new Date().getTime().toString(),
        onclose: function() {
          setTimeout( () => window.location.assign(url), 1000)
        },
        callback: function(response) {
          setTimeout( () =>  { x.close(); window.location.assign(url) }, 1000)
        }
    });
  }
</script>
