<?php $this->load->view("partial/header"); ?>
	
<script type="text/javascript" src="js/plugins/jquery.numpad.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.numpad.css">		

<script>
function getCost(elmnt,line) {
   $("#cost_item_button_"+line).toggle()
}
</script>
    <div class="row">
        <div id="sales_cart" class="col-md-8">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
				  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				  <li data-target="#myCarousel" data-slide-to="1"></li>
				  <li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>


				<div class="carousel-inner">
				  <div class="item active">
					<img src="<?php echo base_url();?>images/salestime.jpg" style="width:100%; hight:500px;">
				  </div>

			   
				<?php
				foreach($shows as $show)
				{
				?>
				 <div class="item">
					<img src="<?php echo base_url();?>images/slides/<?php echo $show;?>" style="width:100%; hight:500px;">
				</div>
				<?php
				}
				?>
				</div>

			</div>
		</div>
		
		<div  id="overall_sales" class="panel panel-default col-md-4">
			<table class="sales_table_1001" id="sale_totals">
				<tr>
					<th style="width: 55%;"><?php echo $this->lang->line('sales_quantity_of_items',$item_count); ?></th>
					<th style="width: 45%; text-align: right;"><?php echo $total_units; ?></th>
				</tr>

				<tr>
					<th style='width: 55%;'><?php echo $this->lang->line('sales_total'); ?></th>
					<th style="width: 45%; text-align: right;"><span id="sale_total"><?php echo to_currency($total); ?></span></th>
				</tr>
			</table>	
		
			<div class="table-responsive">
				<table class="table table-bordered" id="register">
					<thead>
						<tr>
							<th style="width: 5%;"></th>
							<th style="width: 30%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_price'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_qty'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_total'); ?></th>
							<th style="width: 5%;"></th>
						</tr>
					</thead>

					<tbody id="cart_contents">	
					</tbody>
				</table>
			</div>	
		</div>		
    </div>

<script type="text/javascript">

$(document).ready(function()
{
	setInterval(play_me, 1000);

	function play_me() {
		
	$.post('sales/add', {item: -1}, function(response){
	    	$("#cart_contents").html($(response).find("#cart_contents").html());
			$("#sale_totals").html($(response).find("#sale_totals").html());
		});
 
    }
});
</script>




<?php $this->load->view("partial/footer"); ?>
