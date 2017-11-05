<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$db =& DB();
			  $db->where('id',1);	
$sett = $db->get( 'settings' )->row();

// Use PayPal on Sandbox or Live
$config['sandbox'] = ($sett->paypal_sandbox==1)?TRUE:FALSE; // FALSE for live environment

// PayPal Business Email ID
$config['business'] = $sett->paypal_business_email;

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = TRUE;

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';

// What is the default currency?
$config['paypal_lib_currency_code'] = 'USD';
?>