<?php $this->lang->load("calendar"); $this->lang->load("date"); 
	if(empty($this->config->item('date_or_time_format')))
	{
?>
		$('#daterangepicker').css("width","180");
		var end_date   = "<?php echo date('Y-m-d') ?>";

		$('#daterangepicker').daterangepicker({
			"locale": {
				"format": '<?php echo dateformat_momentjs($this->config->item("dateformat"))?>',
				"separator": " - ",
				"applyLabel": "<?php echo $this->lang->line("datepicker_apply"); ?>",
				"cancelLabel": "<?php echo $this->lang->line("datepicker_cancel"); ?>",
				"fromLabel": "<?php echo $this->lang->line("datepicker_from"); ?>",
				"toLabel": "<?php echo $this->lang->line("datepicker_to"); ?>",
				"customRangeLabel": "<?php echo $this->lang->line("datepicker_custom"); ?>",
				"daysOfWeek": [
					"<?php echo $this->lang->line("cal_su"); ?>",
					"<?php echo $this->lang->line("cal_mo"); ?>",
					"<?php echo $this->lang->line("cal_tu"); ?>",
					"<?php echo $this->lang->line("cal_we"); ?>",
					"<?php echo $this->lang->line("cal_th"); ?>",
					"<?php echo $this->lang->line("cal_fr"); ?>",
					"<?php echo $this->lang->line("cal_sa"); ?>",
					"<?php echo $this->lang->line("cal_su"); ?>"
				],
				"monthNames": [
					"<?php echo $this->lang->line("cal_january"); ?>",
					"<?php echo $this->lang->line("cal_february"); ?>",
					"<?php echo $this->lang->line("cal_march"); ?>",
					"<?php echo $this->lang->line("cal_april"); ?>",
					"<?php echo $this->lang->line("cal_may"); ?>",
					"<?php echo $this->lang->line("cal_june"); ?>",
					"<?php echo $this->lang->line("cal_july"); ?>",
					"<?php echo $this->lang->line("cal_august"); ?>",
					"<?php echo $this->lang->line("cal_september"); ?>",
					"<?php echo $this->lang->line("cal_october"); ?>",
					"<?php echo $this->lang->line("cal_november"); ?>",
					"<?php echo $this->lang->line("cal_december"); ?>"
				],
				"firstDay": <?php echo $this->lang->line("datepicker_weekstart"); ?>
			},
		    "timePicker": true,
		    "timePickerSeconds": true,
			"singleDatePicker": true,
			"alwaysShowCalendars": true,
			"autoclose": true,
		    "todayBtn": true,
		    "todayHighlight": true,
			"startDate": "<?php //echo date($this->config->item('dateformat'), mktime(0,0,0,date("m"),date("d")+1,date("Y"))-1);?>",
			"minDate": "<?php echo date($this->config->item('dateformat'), mktime(0,0,0,01,01,2010));?>",
			"maxDate": "<?php echo date($this->config->item('dateformat'), mktime(0,0,0,date("m"),date("d")+1,date("Y"))-1);?>"
		}, function(start, end, label) {
			end_date = end.format('YYYY-MM-DD');
		});
<?php
	}
	else
	{
?>
		$('#daterangepicker').css("width","305");
		var end_date = "<?php echo date('Y-m-d H:i:s', mktime(23,59,59,date("m"),date("d"),date("Y")))?>";
		$('#daterangepicker').daterangepicker({
					"ranges": {
				"<?php echo $this->lang->line("datepicker_today"); ?>": [
					"<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'), mktime(0,0,0,date("m"),date("d"),date("Y")));?>"
				],
				"<?php echo $this->lang->line("datepicker_today_last_year"); ?>": [
					"<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,date("m"),date("d"),date("Y")-1));?>"
				],
				"<?php echo $this->lang->line("datepicker_yesterday"); ?>": [
					"<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,date("m"),date("d")-1,date("Y")));?>"
				],
				"<?php echo $this->lang->line("datepicker_last_7"); ?>": [
					"<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,date("m"),date("d")-6,date("Y")));?>"
				],
				"<?php echo $this->lang->line("datepicker_last_30"); ?>": [
					"<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,date("m"),date("d")-29,date("Y")));?>"
				]
			},
			"locale": {
				"format": '<?php echo dateformat_momentjs($this->config->item("dateformat")." ".$this->config->item('timeformat'))?>',
				"separator": " - ",
				"applyLabel": "<?php echo $this->lang->line("datepicker_apply"); ?>",
				"cancelLabel": "<?php echo $this->lang->line("datepicker_cancel"); ?>",
				"fromLabel": "<?php echo $this->lang->line("datepicker_from"); ?>",
				"toLabel": "<?php echo $this->lang->line("datepicker_to"); ?>",
				"customRangeLabel": "<?php echo $this->lang->line("datepicker_custom"); ?>",
				"daysOfWeek": [
					"<?php echo $this->lang->line("cal_su"); ?>",
					"<?php echo $this->lang->line("cal_mo"); ?>",
					"<?php echo $this->lang->line("cal_tu"); ?>",
					"<?php echo $this->lang->line("cal_we"); ?>",
					"<?php echo $this->lang->line("cal_th"); ?>",
					"<?php echo $this->lang->line("cal_fr"); ?>",
					"<?php echo $this->lang->line("cal_sa"); ?>",
					"<?php echo $this->lang->line("cal_su"); ?>"
				],
				"monthNames": [
					"<?php echo $this->lang->line("cal_january"); ?>",
					"<?php echo $this->lang->line("cal_february"); ?>",
					"<?php echo $this->lang->line("cal_march"); ?>",
					"<?php echo $this->lang->line("cal_april"); ?>",
					"<?php echo $this->lang->line("cal_may"); ?>",
					"<?php echo $this->lang->line("cal_june"); ?>",
					"<?php echo $this->lang->line("cal_july"); ?>",
					"<?php echo $this->lang->line("cal_august"); ?>",
					"<?php echo $this->lang->line("cal_september"); ?>",
					"<?php echo $this->lang->line("cal_october"); ?>",
					"<?php echo $this->lang->line("cal_november"); ?>",
					"<?php echo $this->lang->line("cal_december"); ?>"
				],
				"firstDay": <?php echo $this->lang->line("datepicker_weekstart"); ?>
			},
		    "timePicker": true,
		    "timePickerSeconds": true,
			"singleDatePicker": true,
			"alwaysShowCalendars": true,
			"autoclose": true,
		    "todayBtn": true,
		    "todayHighlight": true,
			minuteStep: 1,
			"startDate": "<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,date("m"),date("d"),date("Y")));?>",
			"minDate": "<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(0,0,0,01,01,2019));?>",
			"maxDate": "<?php echo date($this->config->item('dateformat')." ".$this->config->item('timeformat'),mktime(23,59,59,date("m"),date("d"),date("Y")));?>"
		}, function(start, end, label) {
			end_date = end.format('YYYY-MM-DD HH:mm:ss');
		});
<?php
	}
?>