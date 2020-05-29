<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

	<fieldset id="item_basic_info">
<button class="btn btn-default btn-sm print_hide"><a href="https://api.whatsapp.com/send?phone=<?php echo $this->config->item('calling_codes').''. $mobile; ?>&text=Hi <?php echo $first_name; ?> Thank you For Chose I want Tell some Thing about <?php echo $company; ?> Order Number <?php echo $order_id; ?>" class="float" target="_blank"><?php echo $this->lang->line('services_whatsapp_send_a_message');?></a></button>
<button class="btn btn-default btn-sm print_hide"><a href="https://api.whatsapp.com/send?phone=<?php echo $this->config->item('calling_codes').''. $mobile; ?>&text=<?php echo $message; ?>" class="float" target="_blank"><?php echo $this->lang->line('services_whatsapp_confirm');?></a></button>
<button class="btn btn-default btn-sm print_hide"><a href="https://api.whatsapp.com/send?phone=<?php echo $this->config->item('calling_codes').''. $mobile; ?>&text=Hi <?php echo $first_name; ?> Your Device <?php echo $company; ?> With Order Number <?php echo $order_id; ?> is Completed, Please Collect it" class="float" target="_blank"><?php echo $this->lang->line('services_whatsapp_completed');?></a></button>
<button class="btn btn-default btn-sm print_hide"><a href="https://api.whatsapp.com/send?phone=<?php echo $this->config->item('calling_codes').''. $mobile; ?>&text=Hi <?php echo $first_name; ?> , Engneer Rejected Your Device <?php echo $company; ?> with Order Number <?php echo $order_id; ?> , Please Collect it" class="float" target="_blank"><?php echo $this->lang->line('services_whatsapp_Rejected');?></a></button>
	</fieldset>

		
		
		
		