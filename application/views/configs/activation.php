<?php echo form_open('config/save_activation/', array('id' => 'activation_form', 'class' => 'form-horizontal')); ?>
	<div id="config_wrapper">
		<fieldset id="config_info">
			<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
			<ul id="tax_error_message_box" class="error_message_box"></ul>
<?php
if(!$activated)
{
?>
	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('config_installation_key'), 'config_installation_key', array('class' => 'control-label col-xs-2')); ?>
		<div class='col-xs-6'>
			<?php echo form_label($reg_key, 'config_installation_key', array('class' => 'control-label col-xs-6')); ?>
		</div>
	</div>
			
	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('config_trial_period'), 'config_installation_key', array('class' => 'control-label col-xs-2')); ?>
		<div class='col-xs-6'>
			<?php echo form_label($trial_time .' Days for Expiration', 'config_installation_key', array('class' => 'control-label col-xs-6')); ?>
		</div>
	</div>
			
	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('config_activation_key'), 'activation_key', array('class' => 'control-label col-xs-2')); ?>
		<div class='col-xs-5'>
			<?php echo form_input(array(
			'name' => 'activation_key',
			'id' => 'activation_key',
			'class' => 'form-control input-sm')); ?>
		</div>
	</div>

<?php
}
else
{
?>
	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('config_status'), 'config_status', array('class' => 'control-label col-xs-2')); ?>
		<div class='col-xs-6'>
			<?php echo form_label($this->lang->line('config_activatated'), 'config_activatated', array('class' => 'control-label col-xs-6')); ?>
		</div>
	</div>
			
	
			

<?php
}
?>
	<?php echo form_submit(array(
		'name' => 'submit_actiavtion',
		'id' => 'submit_actiavtion',
		'value' => $this->lang->line('common_submit'),
		'class' => 'btn btn-primary btn-sm pull-right')); ?>

		</fieldset>
	</div>
<?php echo form_close(); ?>

<script type="text/javascript">
//validation and submit handling
$(document).ready(function()
{

	$('#activation_form').validate($.extend(form_support.handler, {
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response) {
					$.notify(response.message, { type: response.success ? 'success' : 'danger'} );
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#activation_error_message_box'
	}));
});
</script>
