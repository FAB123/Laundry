<ul id="error_message_box" class="error_message_box"></ul>
<?php echo form_open('', array('id'=>'action_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">
	<div class=col-xs-12>
	<table class="table table-sm table-bordered">
  <thead>
    <tr>
      <th colspan="5" class="text-center"><?php echo $this->lang->line('services_summary'); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td width="20%" scope="row"><?php echo $this->lang->line('services_current_eng'); ?></th>
      <td width="20%" ><?php echo (!empty($service_info->engineer_id) ? $engineers[$service_info->engineer_id] : ''); ?></td>
	  <td width="10%"></td>
      <td width="20%"><?php echo $this->lang->line('services_current_status'); ?></td>
      <td width="20%"><?php echo $this->Service->get_status_name($service_info->status); ?></td>
    </tr>
    <tr>
      <td scope="row"><?php echo $this->lang->line('service_est'); ?></th>
      <td><?php echo to_currency($service_info->est_amount); ?></td>
	  <td></td>
      <td><?php echo $this->lang->line('service_job_status'); ?></td>
      <td><?php echo ($service_info->canceled == 1) ? $this->lang->line('services_canceled') :  $this->lang->line('service_job_normal') ;?></td>
    </tr>

    <tr>
      <td scope="row"><?php echo $this->lang->line('receivings_comments'); ?></th>
      <td><?php echo $service_info->comment; ?></td>
	  <td></td>
      <td scope="row"><?php echo $this->lang->line('receivings_comments'); ?></th>
      <td><?php echo $service_info->comment; ?></td>

    </tr>
  </tbody>
</table>
</div>

	<div class=col-xs-12>
	<table class="table table-sm table-bordered">
  <thead>
    <tr>
      <th colspan="7" class="text-center"><?php echo $this->lang->line('services_details'); ?></th>
    </tr>
	<tr>
		<th width="15%"><?php echo $this->lang->line('services_transaction'); ?></th>
		<th width="10%"><?php echo $this->lang->line('services_status'); ?></th>
	    <th width="12%"><?php echo $this->lang->line('employees_employee'); ?></th>
	</tr>
  </thead>
  <tbody>
    <?php
	foreach($reports as $report)
	{
	?>
		<tr>
			<td><?php echo $report['transfer_date']; ?></td>
			<td><?php echo $this->Service->get_status_name($report['status']); ?></td>
			<td><?php echo $report['first_name'] .' '. $report['last_name']; ?></td>
		</tr>
	<?php
	}
	?>
  </tbody>
</table>
</div>
	<?php
        if($service_info->delivery == 1) { ?>
<div class=col-xs-5>
		<table id="used_spares" class="table table-striped  table-bordered table-hover">
			<thead>
				<tr>
				    <th colspan="2" class="text-center"><?php echo $this->lang->line('services_delivery_details'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td  width="50%"><?php echo $this->lang->line('service_despatch_date'); ?></td>
					<td  width="50%"><?php echo $service_info->desp_date; ?></td>
				</tr>
				<tr>
					<td  width="50%"><?php echo $this->lang->line('service_otp_verified'); ?></td>
					<td  width="50%"><?php echo $this->Service->get_avaiablity($otp_verified); ?></td>
				</tr>
				<tr>
				<?php
                if($sign_exists) { ?>
                <td  colspan="2">
				    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 155px;">
					    <img data-src="holder.js/100%x100%" alt="<?php echo $this->lang->line('desk_saved_sign'); ?>"
						    src="<?php  echo 'data:image/png;base64,'.base64_encode( $image_sign); ?>"
						    style="max-height: 100%; max-width: 100%;">
				    </div>
			    </td>
				<?php } ?>

				</tr>
			</tbody>
		</table>
</div>
	<?php } ?>


	</fieldset>
<?php echo form_close(); ?>

<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	
	$('#action_form').validate($.extend({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response)
				{
					dialog_support.hide();
				},
			});
		},

		errorLabelContainer: '#error_message_box',

		ignore: '',

	}, form_support.error));
});
</script>