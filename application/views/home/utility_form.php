<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('home/save1/'.$person_info->person_id, array('id'=>'employee_form', 'class'=>'form-horizontal')); ?>

	<ul class="nav nav-tabs" data-tabs="tabs">
		<li class="active" role="presentation">
			<a data-toggle="tab" href="#transilator_utility"><?php echo $this->lang->line("transilator_utility"); ?></a>
		</li>
		<li role="presentation">
			<a data-toggle="tab" href="#calculator_utility"><?php echo $this->lang->line("calculator_utility"); ?></a>
		</li>

	</ul>

	<div class="tab-content">
		<div class="tab-pane fade in active" id="transilator_utility">
			<fieldset>
			<div id="required_fields_message"><?php echo $this->lang->line('transilator_operation'); ?></div>
				<div class="form-group form-group-sm">
					<?php echo form_label($this->lang->line('home_text_english'), 'source', array('class'=>'control-label col-xs-3')); ?>
					<div class='col-xs-8'>
						<?php echo form_textarea(array(
								'name'=>'text_english',
								'id'=>'text_english',
								'class'=>'form-control input-sm')
								);?>
					</div>
				</div>
				
				<div class="form-group form-group-sm">
					<?php echo form_label($this->lang->line('home_text_arabic'), 'destination', array('class'=>'control-label col-xs-3')); ?>
					<div class='col-xs-8'>
						<?php echo form_textarea(array(
								'name'=>'text_arabic',
								'id'=>'text_arabic',
								'class'=>'form-control input-sm',
								'readonly'=>'true')
								);?>
					</div>
				</div>
				
				<div class='status'></div>
			</fieldset>
		</div>

		<div class="tab-pane" id="calculator_utility">	
		    <div id="required_fields_message"><?php echo $this->lang->line('calculator_equation_operation'); ?></div>
				<div class="form-group form-group-sm">
						<?php echo form_label($this->lang->line('calculator_equation'), 'custom_label', array('class'=>'control-label col-xs-3')); ?>
						<div class='col-xs-8'>
							<?php echo form_input(array(
									'name'=>'calc',
									'id'=>'calc',
									'class'=>'form-control input-sm')
							);?>
						</div>
				</div>
						
			</fieldset>
		</div>
	</div>
<?php echo form_close(); ?>

<style type="text/css">
textarea {
 font-size: 1em;
 font-weight: bold;
 font-family: Verdana, Arial, Helvetica, sans-serif;
 border: 1px solid black;
}
</style>

<script type="text/javascript">



//validation and submit handling
$(document).ready(function()
{
	$("#text_english").change(function(){
        var text_english = $(this).val();
		
		 $.ajax({
            url: '<?php echo site_url('home/convert_text') ?>',
            type: 'post',
            data: {text_english:text_english},
            dataType: 'json',
            success:function(response){
	            var result = response.result;
				$(".status").text(result).show().fadeOut(5200);
                $('#text_arabic').val(result);				
            }
        });
    });
	
	$("#text_english").keydown(function (e) {
		if (e.keyCode == 32) { 
		    var text_english = $(this).val();
		
			$.ajax({
				url: '<?php echo site_url('home/convert_text') ?>',
				type: 'post',
				data: {text_english:text_english},
				dataType: 'json',
				success:function(response){
					var result = response.result;
					$(".status").text(result).show().fadeOut(5200);
					$('#text_arabic').val(result);				
				}
			});
		}
    });
	
	$('#text_arabic').click(function() {
		$(this).focus();
		$(this).select();
		document.execCommand('copy');
		$(".status").text("Copied to clipboard").show().fadeOut(5200);
    });
	
	
    $("#calc").change(function(){
        var calculate = $(this).val();
		
		 $.ajax({
            url: '<?php echo site_url('home/calculate_number') ?>',
            type: 'post',
            data: {calculate:calculate},
            dataType: 'json',
            success:function(response){
	            var result = response.result;
                $('#calc').val(result);				
            }
        });
    });
	
	         
});
</script>
