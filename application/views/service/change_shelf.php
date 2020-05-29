<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('services/save_new_shelf/'.$service_info->order_id, array('id'=>'save_shelf_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">
	<?php if($service_info->shelf_type == '0'){ ?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('shelf_type'), 'type_label', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_dropdown('shelf_type', $types, '0', array('class'=>'form-control', 'id'=>'shelf_type')); ?>
			</div>
		</div>
	    <?php } else { ?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('shelf_type'), 'type_label', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
			    <?php echo form_label($this->Item_name->get_location_name($service_info->shelf_type), 'type_label', array('class'=>'control-label col-xs-3')); ?>
			</div>
		</div>
		    <?php echo form_hidden('shelf_type', $service_info->shelf_type); ?>
	    <?php } ?>

		<div class="form-group form-group-sm shelf">
			<?php echo form_label($this->lang->line('shelf'), 'shelf', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_dropdown('shelf', $shelfs, '0', 'id="shelf" class="form-control" data-live-search="true"'); ?>
			</div>
		</div>
	</fieldset>

<?php echo form_close(); ?>

<script type="text/javascript">

//validation and submit handling
$(document).ready(function()
{
	$("#shelf_type").change(function(){
        var shelf_type = $(this).val();
        $.ajax({
            url: '<?php echo site_url('receivings/get_all_available_shelfs') ?>',
            type: 'post',
            data: {shelf_types:shelf_type},
            dataType: 'json',
            success:function(response){
	            var len = response.length;

                $("#shelf").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['shelf_id'];
                    var name = response[i]['shelf_name'];
                    
                    $("#shelf").append("<option value='"+id+"'>"+name+"</option>");
                }
            }
        });
    });
		
		

    $('#save_shelf_form').validate($.extend({
		
	   	submitHandler: function(form) {
    		$(form).ajaxSubmit({
	   			success: function(response)
	   			{
	   				dialog_support.hide();
	   				table_support.refresh();
	   			},
	   		});
	   	},

     	errorLabelContainer: '#error_message_box',

     	rules:
    	{
    		shelf:
     		{
    			required: true,
    			remote:
    			{
     				url: "<?php echo site_url($controller_name . '/check_shelf') ?>",
    				type: 'POST'
    			}
	    	}
    	},

    	messages:
    	{
   			shelf: 
    		{
	    		remote: "<?php echo $this->lang->line('shelf_duplicate'); ?>",
		    	required: "<?php echo $this->lang->line('shelf_required'); ?>"
	    	}

   		},
   	}, form_support.error));
});
</script>

