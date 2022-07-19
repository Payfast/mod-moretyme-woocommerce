<?php
// to check whether accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$woocommerceFile = WP_PLUGIN_DIR . '/woocommerce/includes/admin/settings/class-wc-settings-page.php';
if (!file_exists($woocommerceFile)) {
  exit('Please ensure that WooCommerce has been installed and activated on your site before activating the MoreTyme Widget for WooCommerce');
}
require_once $woocommerceFile;
class PayFast_Moretyme_Enable_Settings extends WC_Settings_Page {
	public function __construct() {
		$this->init();
		$this->id = 'payfast_moretyme';
	}

	public function init() {
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'payfast_moretyme_add_settings_tab' ), 50 );
	}

	public function payfast_moretyme_add_settings_tab( $settings_tabs ) {
		$settings_tabs['payfast_moretyme'] = 'PayFast Moretyme';
		return $settings_tabs;
	}
}

add_action( 'woocommerce_settings_tabs_payfast_moretyme', 'payfast_moretyme_settings_tab' );
function payfast_moretyme_settings_tab() {
	woocommerce_admin_fields( payfast_moretyme_get_setting() );
}

function payfast_moretyme_get_setting() {
	global $current_section;
  $settings = [
      'amount' => 500,
      'theme' => get_option('pf-mt-theme', null),
      'font' => get_option('pf-mt-font', 'Lato'),
      'font-color' => get_option('pf-mt-font-color', null),
      'link-color' => get_option('pf-mt-link-color', null),
      'logo-align' => get_option('pf-mt-logo-align', null),
      'logo-type' => get_option('pf-mt-logo-type', null),
      'size' => get_option('pf-mt-size', null),
  ];
?>
    <style>
      #pf-mt-preview {
          min-height: 105px;
          border: 1px solid #ccc;
      }

      div#pf-mt-preview > div {
        padding-right: 2rem!important;
        padding-left: 2rem!important;
      }

      .tab-col {
          max-width: 33%;
          display: inline-block;
          vertical-align: top;
          width: 100%;
      }

      @media only screen and (max-width: 680px) {
        .tab-col {
          max-width: 50%;
        }
      }

<?php
      if (get_option('woocommerce_currency') != 'ZAR') {
        echo ".woocommerce-save-button {
          display: none!important;
        }";
      }
      
?>
    </style>
		<script type="text/javascript">
		jQuery(function($){

      $('.pf-mt-input').change(function() {
        let opts = {
          amount: 500,
          theme: $('[name=theme]:checked').val(),
          font: $('[name=font]').val(),
          'font-color': $('[name=font-color]').val(),
          'link-color': $('[name=link-color]').val(),
          'logo-align': $('[name=logo-align]:checked').val(),
          'logo-type': $('[name=logo-type]:checked').val(),
          size: $('[name=size]:checked').val(),
        };

        if (opts['theme'] == 'dark') {
          $('#pf-mt-preview').css('background-color', '#000000');
          $('#payfast-logo-type').show();
          $('#payfast-font-color').hide();
        } else {
          $('#pf-mt-preview').css('background-color', '#FFFFFF');
          $('#payfast-logo-type').hide();
          $('#payfast-font-color').show();
        }

        if (opts['size'] != 'small') {
          $('#payfast-link-color').show();
        } else {
          $('#payfast-link-color').hide();
        }

        var s = document.createElement("script");
        s.type = "text/javascript";

        for (var key in opts) {
          s.setAttribute('data-' + key, opts[key]);
        }

        $('#pf-mt-preview').empty().append(s);

        s.src = "https://content.payfast.co.za/widgets/moretyme/widget.min.js";
      });
		});
	</script>
    <section>
<?php 
      if (get_option('woocommerce_currency') == 'ZAR') {
?>
        <h1>MoreTyme</h1>
        <h3>MoreTyme Add-ons for Your Website</h3>
        <p>Create a personalised widget for your product web pages and increase sales on your site. The widget informs your customers how much they need to pay upfront and for the next two payments with MoreTyme.</p>

        <div id="pf-mt-preview" style="background-color: <?php echo ($settings['theme'] == 'dark' ? '#000000' : '#ffffff') ?>;">
            <script async src="https://content.payfast.co.za/widgets/moretyme/widget.min.js?<?php echo str_replace('%23', '#', http_build_query($settings)) ?>" type="text/javascript"></script>
        </div>

        <div class="tab-col mode">
            <h4>Mode</h4>
            <label for="light-mode">Light Mode</label>
            <input type="radio" name="theme" class="pf-mt-input" value="light" id="light-mode"
                <?php echo ($settings['theme'] != 'dark' ? 'checked' : '') ?>/>
            <label for="dark-mode">Dark Mode</label>
            <input type="radio" name="theme" class="pf-mt-input" value="dark" id="dark-mode"
                <?php echo ($settings['theme'] == 'dark' ? 'checked' : '') ?>/>

            <h4>Widget size</h4>
            <label for="size-standard">Standard</label>
            <input type="radio" name="size" class="pf-mt-input" value="standard" id="size-standard"
                <?php echo ($settings['size'] != 'small' ? 'checked' : '') ?>/>
            <label for="size-small">Small</label>
            <input type="radio" name="size" class="pf-mt-input" value="small" id="size-small"
                <?php echo ($settings['size'] == 'small' ? 'checked' : '') ?>/>
        </div>

        <div class="tab-col logos">
            <h4>Logos alignment</h4>
            <label for="align-inline">Inline</label>
            <input type="radio" name="logo-align" class="pf-mt-input" value="inline" id="align-inline"
                <?php echo (!in_array($settings['logo-align'], array('right', 'above', 'below')) ? 'checked' : '') ?>/>
            <br/>
            <label for="align-right">Right Aligned</label>
            <input type="radio" name="logo-align" class="pf-mt-input" value="right" id="align-right"
                <?php echo ($settings['logo-align'] == 'right' ? 'checked' : '') ?>/>
            <br/>
            <label for="align-above">Above content</label>
            <input type="radio" name="logo-align" class="pf-mt-input" value="above" id="align-above"
                <?php echo ($settings['logo-align'] == 'above' ? 'checked' : '') ?>/>
            <br/>
            <label for="align-below">Below content</label>
            <input type="radio" name="logo-align" class="pf-mt-input" value="below" id="align-below"
                <?php echo ($settings['logo-align'] == 'below' ? 'checked' : '') ?>/>

            <div id="payfast-logo-type" <?php echo ($settings['theme'] != 'dark' ? 'style="display: none;"' : '') ?>>
              <h4>Payfast logo type</h4>
              <label for="left-side">Red</label>
              <input type="radio" name="logo-type" class="pf-mt-input" value="red"
                  <?php echo ($settings['logo-type'] != 'white' ? 'checked' : '') ?>/>
              <label for="right-side">White</label>
              <input type="radio" name="logo-type" class="pf-mt-input" value="white"
                  <?php echo ($settings['logo-type'] == 'white' ? 'checked' : '') ?>/>
            </div>
        </div>

        <div class="tab-col fonts">
            <h4>Fonts</h4>
            <select name="font" class="pf-mt-input">
                <option value="Arial" <?php echo ($settings['font'] == 'Arial' ? 'selected' : '') ?>>Arial </option>
                <option value="Garamond" <?php echo ($settings['font'] == 'Garamond' ? 'selected' : '') ?>> Garamond </option>
                <option value="Helvetica" <?php echo ($settings['font'] == 'Helvetica' ? 'selected' : '') ?>> Helvetica </option>
                <option value="Lato" <?php echo ($settings['font'] == 'Lato' ? 'selected' : '') ?>> Lato </option>
                <option value="Merriweather" <?php echo ($settings['font'] == 'Merriweather' ? 'selected' : '') ?>> Merriweather </option>
                <option value="Merriweather-Sans" <?php echo ($settings['font'] == 'Merriweather-Sans' ? 'selected' : '') ?>> Merriweather Sans </option>
                <option value="Montserrat" <?php echo ($settings['font'] == 'Montserrat' ? 'selected' : '') ?>> Montserrat </option>
                <option value="Open-Sans" <?php echo ($settings['font'] == 'Open-Sans' ? 'selected' : '') ?>> Open Sans </option>
                <option value="Oswald" <?php echo ($settings['font'] == 'Oswald' ? 'selected' : '') ?>> Oswald </option>
                <option value="PT-Sans" <?php echo ($settings['font'] == 'PT-Sans' ? 'selected' : '') ?>> PT Sans </option>
                <option value="Raleway" <?php echo ($settings['font'] == 'Raleway' ? 'selected' : '') ?>> Raleway </option>
                <option value="Roboto" <?php echo ($settings['font'] == 'Roboto' ? 'selected' : '') ?>> Roboto </option>
                <option value="Source-Sans-Pro" <?php echo ($settings['font'] == 'Source-Sans-Pro' ? 'selected' : '') ?>> Source Sans Pro </option>
                <option value="Times-New-Roman" <?php echo ($settings['font'] == 'Times-New-Roman' ? 'selected' : '') ?>> Times-New-Roman </option>
                <option value="Verdana" <?php echo ($settings['font'] == 'Verdana' ? 'selected' : '') ?>> Verdana </option>
            </select>

			<div id="payfast-font-color" <?php echo ($settings['theme'] == 'dark' ? 'style="display: none;"' : '') ?>>
				<h4>Select Font Color</h4>
				<input type="color" name="font-color" class="pf-mt-input" value="<?php echo $settings['font-color'] ?: '#041B2B' ?>" />
			</div>
            <div id="payfast-link-color" <?php echo ($settings['size'] == 'small' ? 'style="display: none;"' : '') ?>>
                <h4>'Learn More' link colour</h4>
                <input type="color" name="link-color" class="pf-mt-input" value="<?php echo $settings['link-color'] ?: '#177EE8' ?>">
            </div>
        </div>
<?php
      } else {
?>
          <h3>Please set your Shop Currency to ZAR in order to use this feature.</h3>
          <h4>To change your shop currency settings go to: WooCommerce > Settings > General > Currency Options , and select ZAR from the Currency drop down.</h4>
<?php
      }
?>
    </section>
<?php
}

if (!empty($_POST) && isset($_POST['save'])) {
    $opts = array(
        'theme',
        'font',
        'font-color',
        'link-color',
        'logo-align',
        'logo-type',
        'size',
    );

    foreach ($opts as $o) {
      $option = isset($_POST[$o]) ? $_POST[$o] : null;
      if (!empty($option)) {
        update_option('pf-mt-' . $o, sanitize_text_field($option));
      }
    }
}
new PayFast_Moretyme_Enable_Settings();
?>
