<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box" class="error_message_box"></ul>


    <script src="<?php echo base_url();?>assets/jquery.signaturepad.js"></script>
    <script src="<?php echo base_url();?>assets/json2.min.js"></script>
	
	<link href="<?php echo base_url();?>assets/jquery.signaturepad.css" rel="stylesheet">

<?php echo form_open('services/save_despatch/'.$service_info->order_id, array('id'=>'despatch_form', 'class'=>'form-horizontal')); ?>
	<fieldset class='sigPad'>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('services_current_eng'), '', array('class'=>'control-label col-xs-3')); ?>
            <?php echo form_label(!empty($service_info->engineer_id) ? $engineers[$service_info->engineer_id] : '', 'expenses_info_id', array('class'=>'control-label col-xs-8', 'style'=>'text-align:left')); ?>
			<?php echo form_hidden('shelf', $service_info->shelf); ?>
			<?php echo form_hidden('status', $service_info->status);?>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('services_current_status'), 'status1', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-9'>
				<?php echo form_label($this->Service->get_status_name($service_info->status), 'status1', array('class'=>'control-label')); ?>
			</div>
		</div>
		
	 	<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_spare'), 'status', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_label($service_info->spare, 'status', array('class'=>'control-label')); ?>
			</div>
		</div>
				<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('status_include'), 'feedback', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-9'>
				<?php echo form_label('Battery: '.$this->Service->get_avaiablity($service_info->b_toggle) .', Charger: '.$this->Service->get_avaiablity($service_info->c_toggle) .', Bag: '.$this->Service->get_avaiablity($service_info->bag_toggle), 'feedback', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('receivings_comments'), 'comments', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-9'>
				<?php echo form_label($service_info->comment, 'comments', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_est'), 'status', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_label(to_currency_no_money($service_info->est_amount), 'status', array('class'=>'control-label')); ?>
			</div>
		</div>
		
		<?php if($on_site == 0) { ?>
		<?php if($this->config->item('enable_otp')) { ?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_varify_otp'), 'service_send_otp_label', array('class'=>'required control-label col-xs-3')); ?>

			<div class="col-xs-3">
				<div class="input-group input-group-sm">
					<?php echo form_input(array(
					'name'=>'send_otp',
					'id'=>'send_otp',
					'class'=>'form-control input-sm',
					'value'=>'')
					);?>
				</div>
			</div>
			
			<div class='col-xs-2'>
                <button class="send_otp_btn btn btn-default btn-sm"><?php echo $this->lang->line('service_send_otp'); ?></button>
            </div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label('', 'service_send_otp_label', array('class'=>'control-label col-xs-6')); ?>
			<div class='col-xs-5'>
                <p style="color:green; display: none" class="send_otp_success"><?php echo $this->lang->line('desk_otp_sended'); ?></p>
                <p style="color:red; display: none" class="send_otp_error"><?php echo $this->lang->line('desk_otp_error_sended'); ?></p>
            </div>
        </div>
		<?php }
		if($this->config->item('enable_sign'))
	    { 		
		    if($sign_exists) { ?>

        <div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('desk_saved_sign'), 'desk_saved_sign', array('class'=>'control-label col-xs-4')); ?>
			<div class='col-xs-8'>
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 155px;">
					<img data-src="holder.js/100%x100%" alt="<?php echo $this->lang->line('desk_saved_sign'); ?>"
						src="<?php  echo 'data:image/png;base64,'.base64_encode( $image_sign); ?>"
						style="max-height: 100%; max-width: 100%;">
				</div>
			</div>
		</div>

    <?php } else { ?>

    <p style="color:red;" class="sign_error_message"></p>
    <p style="color:green;" class="sign_message"></p>
	  <script>
    $(document).ready(function() {
		var options = {bgColour : 'transparent', drawOnly : true};
        $('.sigPad').signaturePad(options);
    } );
  </script>
	<div class="form-group form-group-sm">
		<div class='col-xs-3'>
        </div>		
        <div class='col-xs-4'>
            <div class="sig sigWrapper">
                <canvas class="pad" width="200" height="155" style="background: url('seal.png')"></canvas>
                <input type="hidden" name="output" id="output" class="output">
            </div>
        </div>
	</div>
	
	
	<div class='col-xs-3'>
    </div>		
	
	<div class="form-group form-group-sm">
		<div class='col-xs-7 sigNav'>
            <button class="save_new_sign btn btn-default btn-sm"><?php echo $this->lang->line('desk_save_sign'); ?></button>
            <button class="clearButton btn btn-default btn-sm"><?php echo $this->lang->line('desk_clear_sign'); ?></button>
        </div>
    </div>
    <?php 
	        }
	    }
	}
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
							'value'=>'')
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
					
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('service_feedback'), 'feedback', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-7'>
				<?php echo form_textarea(array(
					'name'=>'feedback',
					'id'=>'feedback',
					'class'=>'form-control input-sm',
					'value'=>$service_info->feedback)
					);?>
			</div>
		</div>
		
		<table id="used_spares" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th width="70%"><?php echo $this->lang->line('spares_name'); ?></th>
					<th width="20%"><?php echo $this->lang->line('spares_amount'); ?></th>
					<th width="10%"><?php echo $this->lang->line('spares_quantity'); ?></th>
					<th width="10%"><?php echo $this->lang->line('reports_spare_total'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($used_spares as $used_spare)
				{
				?>
					<tr>
						<td><?php echo $used_spare['name']; ?></td>
						<td><?php echo $used_spare['unit_price']; ?></td>
						<td><?php echo $used_spare['quantity']; ?></td>
						<td><?php echo $used_spare['total']; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</fieldset>

<?php echo form_close(); ?>




<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	$(".save_new_sign").click(function(event){
	    event.preventDefault();
		var output = $("#output").val();
		
		$(".sign_message").html('');
		$(".sign_error_message").html('');
	
	    $.ajax({
		    url : "<?php echo site_url('services/create_sign/');?>",
		    type: 'POST',
		    dataType:'JSON', 
		    data: {order_id: "<?php echo $service_info->order_id;?>", Output: output},
	        }).done(function(response){ 
			    if(response.success == '1'){
					$(".sign_message").html(response.message);
				}else{
				   	$(".sign_error_message").html(response.message);
				}
		    });
    });
	
	$(".send_otp_btn").click(function(){
        event.preventDefault(); //prevent default action 
		$(".send_otp_error").hide()
		$(".send_otp_success").hide()
	
	 $.ajax({
            type: 'POST',
            url : "<?php echo site_url('services/send_otp/');?>",
		    data: {order_id: "<?php echo $service_info->order_id;?>"},
			dataType:'JSON', 
            success: function (data) {
				if(data.success == '1'){
					$(".send_otp_error").hide()
					$(".send_otp_success").show()
					$(".send_otp_success").html(data.message);
							
				}else{
				   	$(".send_otp_error").show()
				   	$(".send_otp_success").hide()
					$(".send_otp_error").html(data.message);
				}
            },
            error: function (data) {
				$(".send_otp_error").show()
				$(".send_otp_success").hide()
				$(".send_otp_error").html(data.message);
            },
        });
	
    }); 
	
	$('#despatch_form').validate($.extend({
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
		
		rules:
		{
			service_payment: 
			{
				required: true,
				number: true,
				<?php if($on_site ==0) { ?>
				remote:
				{
					url: "<?php echo site_url($controller_name . '/ajax_check_sign') ?>",
					type: 'POST',
					data: {
						'order_id': "<?php echo $service_info->order_id;?>"
					}
				}
				<?php } ?>
			},
			send_otp: 
			{
				<?php if ($this->config->item('otp_priority') == 1) { ?> required: true, <?php } ?>
				maxlength:"6",
				minlength:"6",
				remote:
				{
					url: "<?php echo site_url($controller_name . '/ajax_check_otp') ?>",
					type: 'POST',
					data: {
						'order_id': "<?php echo $service_info->order_id;?>"
					}
				}
			}
		},

		messages: 
		{
			service_payment: 
			{
				remote: "<?php echo $this->lang->line('desk_sign_is_mandatory'); ?>",
				required : "<?php echo $this->lang->line('common_service_payment_required'); ?>",
				number : "<?php echo $this->lang->line('common_service_payment_number'); ?>"
			},
			send_otp: 
			{
				remote: "<?php echo $this->lang->line('desk_otp_wrong'); ?>",
				maxlength : "<?php echo $this->lang->line('desk_otp_number_limited'); ?>",
				minlength : "<?php echo $this->lang->line('desk_otp_number_limited'); ?>",
				required : "<?php echo $this->lang->line('desk_otp_number_required'); ?>"
			}
		}

	}, form_support.error));
	
	
});
</script>

