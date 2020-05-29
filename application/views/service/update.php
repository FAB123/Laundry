
<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('services/save_actions/'.$service_info->order_id, array('id'=>'action_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">

    <?php echo form_hidden('status', $service_info->status);?>
    <?php echo form_hidden('customer_id', $service_info->customer_id);?>
    
	<div id="loadingmessage">
	   	<?php echo $this->Service->get_alert_title($service_info->status); ?>

		<?php if ($service_info->status == 2 || $service_info->status == 3 || $service_info->status == 4 || $service_info->status == 5) { ?>
		<div class="loading_images">
            <img src="images/status/<?php echo $service_info->status; ?>_load.png" />
        </div>
		<?php } ?>
	</div>
	
	<?php
	if ($service_info->status == '1')
	{
	?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('services_transfer_to'), 'employee', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_dropdown('engineer_id', $engineers, $service_info->engineer_id, 'id="engineer_id" class="form-control"');?>
			</div>
		</div>
    <?php
	}
	else
	{
		echo form_hidden('engineer_id', $service_info->engineer_id);
	}
    ?>
	
	<?php
	if ($service_info->status == '3' && $service_info->payment_type == '5')
	{
	?>
      	<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_payment'), 'service_payment', array('class'=>'required control-label col-xs-3')); ?>
			<div class="col-xs-4">
				<div class="input-group input-group-sm">
					<?php if (!currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
					<?php echo form_input(array(
							'name'=>'service_payment',
							'id'=>'service_payment',
							'class'=>'form-control input-sm',
							'value'=>$service_info->est_amount)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_payment_type'), 'service_payment_type', array('class'=>'required control-label col-xs-3')); ?>
			<div class="col-xs-8">		
	            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <?php
		        foreach($payment_options as $payment_key=>$payment_opt)
		        {
		        ?>
	                <label class="btn btn-primary">
	            		<?php echo form_radio(array('name'=>'payment_type', 'type'=>'radio', 'id'=>'payment_types', 'value'=>$payment_key)); ?> <?php echo $payment_opt; ?>
                    </label>
     	        <?php
	    	    }
		        ?>
                </div>
	    	</div>
	    </div>
    <?php
	}
    ?>

	</fieldset>
<?php echo form_close(); ?>

<?php if ($service_info->status != '3')	{ ?>

<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	<?php 
	if($service_info->status == 6)
	{
	?>
        $('.modal').modal('hide') 
		swal("Alert!", "<?php echo $this->Service->get_alert_title($service_info->status); ?>", "success");
	<?php 
	}
	?>
	$('#action_form').validate($.extend({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response)
				{
					dialog_support.hide();
					table_support.handle_submit("<?php echo site_url($controller_name); ?>", response);
					table_support.refresh();
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#error_message_box',

		ignore: '',

	}, form_support.error));
});

</script>

<?php }	?>