<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('accounts/save_head/'.$head_info->trans_id, array('id'=>'accounts_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_header_name'), 'header_name', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group input-group-sm">
					<?php echo form_input(array(
							'name'=>'name',
							'id'=>'name',
							'class'=>'form-control input-sm',
							'value'=>$head_info->name)
					);?>
				</div>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_nature'), 'nature_label', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_dropdown('nature', $natures, $head_info->nature, array('class'=>'form-control', 'id'=>'nature'));?>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_type'), 'type_label', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_dropdown('type', $types, $head_info->type, array('class'=>'form-control', 'id'=>'type'));?>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_description'), 'notes', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_textarea(array(
					'name'=>'description',
					'id'=>'description',
					'class'=>'form-control input-sm',
					'value'=>$head_info->description)
					);?>
			</div>
		</div>

	</fieldset>
<?php echo form_close(); ?>

<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	<?php $this->load->view('partial/datepicker_locale'); ?>

	$('#accounts_form').validate($.extend({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response)
				{
					dialog_support.hide();
					table_support.handle_submit("<?php echo site_url($controller_name); ?>./accounts_chart", response);
					table_support.refresh();
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#error_message_box',

		ignore: '',

		rules:
		{
			name:
			{
				required: true
			}
		},

		messages:
		{
			name:
			{
				required: "<?php echo $this->lang->line('expenses_amount_required'); ?>"
			}
		}
	}, form_support.error));
});
</script>
