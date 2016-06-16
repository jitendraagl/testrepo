<?php
/*------------------------------------------------------------------------
# Split Order
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2015 thekrotek.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

$_['heading_title']       	= "Split Order";
$_['heading_version']   	= "2.1.0";

$_['entry_order_status']    = "Order Status";
$_['help_order_status']     = "Assign status for both orders after split (Default Status - keep base order status).";

$_['text_default']    		= "Default status";

$_['entry_payment']    		= "Payment Method";
$_['help_payment']     		= "Splitted order safe payment method.";

$_['entry_shipping']    	= "Shipping Method";
$_['help_shipping']     	= "Splitted order safe shipping method.";

$_['entry_notify']     		= "Notify Customer";
$_['help_notify']     		= "Send email to customer and inform, that his order was splitted.";

$_['entry_comment']     	= "Add Comment";
$_['help_comment']     		= "Add comment about splitted order to base order, new order and their order history.";

$_['entry_coupons']     	= "Add Coupon";
$_['help_coupons']     		= "Add coupon from base older to splitted order.";

$_['entry_vouchers']     	= "Add Voucher";
$_['help_vouchers']     	= "Add voucher from base older to splitted order.";

$_['entry_rewards']     	= "Add Reward";
$_['help_rewards']     		= "Add reward from base order to splitted order.";

$_['entry_affiliate']     	= "Add Affiliate";
$_['help_affiliate']     	= "Add affiliate from base order to splitted order.";

$_['entry_feedback']     	= "Feedback Mode";
$_['help_feedback']     	= "Display errors, warnings, messages, all or nothing.";

$_['text_feedback_silent']  = "Silent";
$_['text_feedback_full']    = "Full";
$_['text_feedback_errors']  = "Only errors";
$_['text_feedback_warnings']= "Only warnings";
$_['text_feedback_messages']= "Only messages";
	
$_['button_split'] 			= "Split";
$_['column_split'] 			= "Split";

$_['text_base_order'] 		= "Base order";
$_['text_split_order'] 		= "Splitted order";
$_['text_base_comment'] 	= "Order was split. New order ID: %s";
$_['text_split_comment'] 	= "Splitted from order %s.";

$_['text_errors']			= "Split Order errors:";

$_['error_products'] 		= "You did not select any products to split.";
$_['error_base_empty'] 		= "At least one product must stay in base order.";
$_['error_payment'] 		= "Safe payment method applied. Reason: Original payment not available.";
$_['error_shipping'] 		= "Safe shipping method applied. Reason: %s";
$_['error_unavailable'] 	= "Method unavailable or quotes not returned.";
$_['error_creating_order'] 	= "Error creating new order. Try again.";

$_['text_warnings']			= "Split Order warnings:";

$_['text_messages']			= "Split Order messages:";

$_['message_customer'] 		= "Customer data applied.";
$_['message_products'] 		= "Products added to cart.";
$_['message_payment']		= "Payment method applied.";
$_['message_shipping']		= "Shipping method applied.";
$_['message_coupons']		= "Coupon applied.";
$_['message_vouchers']		= "Voucher applied.";
$_['message_rewards']		= "Reward recalculated.";
$_['message_split']			= "Order splitted. New order ID: %s";
$_['message_status']		= "Status for both orders changed.";
$_['message_notified']		= "Customer notified.";

/* Generic language strings */

$_['heading_latest']   		= "You have the latest version: %s";
$_['heading_future']   		= "Wow! You have version %s and it's from THE FUTURE!";
$_['heading_update']   		= "A new version available: %s. Click <a href='http://thekrotek.com/profile/my-orders' title='Download new version' target='_blank'>here</a> to download.";

$_['entry_customer_groups'] = "Customer Groups";
$_['help_customer_groups']  = "Extension will work for selected groups only.";

$_['entry_geo_zone']   		= "Geo Zone";
$_['help_geo_zone']   		= "Extension will work for selected geo zone only.";

$_['entry_tax_class']  		= "Tax Class";
$_['help_tax_class']   		= "Tax class, which will be applied for this extension";

$_['entry_status']     		= "Status";
$_['help_status']   		= "Enable or disable this extension";

$_['entry_sort_order'] 		= "Sort Order";
$_['help_sort_order']   	= "Position in the list of extensions of the same type.";

$_['text_edit_title']       = "Edit %s";

$_['text_total']    		= "Total";
$_['text_module']    		= "Modules";
$_['text_shipping']    		= "Shipping";
$_['text_payment']    		= "Payment";

$_['button_apply']      	= "Apply";

$_['text_content_top']    	= "Content Top";
$_['text_content_bottom'] 	= "Content Bottom";
$_['text_column_left']    	= "Column Left";
$_['text_column_right']   	= "Column Right";

$_['entry_module_layout']   = "Layout:";
$_['entry_module_position'] = "Position:";
$_['entry_module_status']   = "Status:";
$_['entry_module_sort']    	= "Sort Order:";

$_['message_success']     	= "Success: You have modified %s!";

$_['error_permission'] 		= "Warning: You do not have permission to modify %s!";
$_['error_version'] 		= "Impossible to get version information: no connection to server.";
$_['error_fopen'] 			= "Impossible to get version information: allow_url_fopen option is disabled.";
$_['error_empty'] 			= "Error: %s value can't be empty.";
$_['error_numerical'] 		= "Error: %s value should be numerical.";
$_['error_percent'] 		= "Error: %s value should be numerical or in percent.";
$_['error_positive'] 		= "Error: %s value should be zero or more.";
$_['error_curl']      		= "cURL error: (%s) %s. Fix it (if necessary) and try to reinstall.";

?>