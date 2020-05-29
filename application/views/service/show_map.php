<script src="dist/locationpicker.jquery.js"></script>

<script>
        $( document ).ready(function() {

	        $('#drive').click(function() {
                window.open('https://www.google.com/maps/dir//<?php echo $service_info->latitude; ?>,<?php echo $service_info->longitude; ?>', '_blank');
				dialog_support.hide();
            });

	        $('#submit').click(function() {
		        dialog_support.hide();
	        });		
			
			$("#updategeolocation").click(function(event){
	        event.preventDefault();
		    var latitude = $("#us3-lat").val();
		    var longitude = $("#us3-lon").val();
		
		    $("#message").html('');
		    $("#updateerror").html('');
	
	        $.ajax({
		        url : "<?php echo site_url('on/save_geo_location/');?>",
		        type: 'POST',
		        dataType:'JSON', 
		        data: {order_id: "<?php echo $service_id;?>", latitude: latitude, longitude: longitude},
	            }).done(function(response){ 
			        if(response.success == '1'){
				        $("#message").html(response.message);
				    }else{
				        $("#updateerror").html(response.message);
		    	    }
		        });
            });
        });
	
		$('#jed').locationpicker({
			location: {
                latitude: <?php echo $service_info->latitude; ?>,
                longitude: <?php echo $service_info->longitude; ?>
            },
            radius: 20,
            zoom: 17,
            inputBinding: {
                latitudeInput: $('#us3-lat'),
                longitudeInput: $('#us3-lon')
            },
            enableAutocomplete: true,
			enableReverseGeocode: true,
			markerInCenter: true,
			draggable: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
				//alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
            }
        });
    </script>
	<?php
     	if($this->Employee->is_driver($this->session->userdata('person_id')))
		{
			?>	
	        <div class=col-xs-12>
	            <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center"><?php echo $this->lang->line('services_summary'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%" scope="row"><?php echo $this->lang->line('receiving_time'); ?></td>
                            <td width="50%" ><?php echo date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($service_info->receiving_time)); ?></td>
	                    </tr>
						<tr>
                            <td scope="row"><?php echo $this->lang->line('services_customer_name'); ?></th>
                            <td><?php echo $service_info->first_name .' '. $service_info->last_name; ?></td>
	                    </tr>
	                    <tr>
                            <td><?php echo $this->lang->line('common_phone_number'); ?></td>
                            <td><?php echo $this->config->item('calling_codes').''.$service_info->phone_number ;?></td>
                        </tr>
						
                        <tr>
                            <td scope="row"><?php echo $this->lang->line('services_rec_id'); ?></td>
                            <td><?php echo $service_info->service_id; ?></td>
                        </tr>
  
						<tr>
                            <td scope="row"><?php echo $this->lang->line('services_payment_type'); ?></th>
							
                            <td><?php echo $this->Service->get_payment_type($service_info->payment_type); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>	
	<?php
	}
	else
	{
	?>
		<div class="form-group form-group-sm">
			<div class='col-xs-12 text-center'>
				<button type="button" id="updategeolocation" class="btn btn-info ">Save</button>
			</div>
			<div class='col-xs-12 text-center'>
			    <span id="message" style="text-align: center; color: green;"></span>
                <span id="updateerror" style="color:red"></span>
			</div>
		</div>
		
		<div class="form-group" >
			<div class="clearfix">&nbsp;</div>
            <div class="m-t-small">
                <label class="p-r-small col-sm-1 control-label">Lat.:</label>

                <div class="col-sm-3">
                    <input type="text" disabled class="form-control" style="width: 110px" id="us3-lat"/>
                </div>
                <label class="p-r-small col-sm-2 control-label">Long.:</label>

                <div class="col-sm-3">
                    <input type="text" disabled class="form-control" style="width: 110px" id="us3-lon" />
                </div>
                </div>
            <div class="clearfix"></div>
		    <div id="result"></div>
        </div>
	<?php
	}
	?>	
    <div class="form-group" >
	        
        <div id="jed" align="center" style="width: 100%; height: 400px;"></div>
    </div>
		

 