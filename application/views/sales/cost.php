<ul id="error_message_box" class="error_message_box"></ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".cos2").click(function(){
    $(".table-cost").toggle();
	$(".cos3").toggle();
  });
  
    $(".sales2").click(function(){
    $(".user-sales").toggle();
	$(".psales").toggle();
  });
});
</script>
</head>
<body>

<p class="sales2">Sale History</p>            
  <table class="table user-sales table-bordered">
  <p align="center" class="psales"> <b> Current User Sales  </b></p> 
	<thead>
			<tr>
				<th width="50%">Date</th>
				<th width="50%">QTY</th>
				<th width="50%">Price</th>
			</tr>
			</thead>
			<tbody>
				<?php
				foreach($sales as $report)
				{
				?>
					<tr>
					<td><?php echo $report['sale_time']; ?></td>
					<td><?php echo $report['quantity_purchased']; ?></td>
					<td><?php echo $report['item_unit_price']; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
   <table class="table user-sales table-bordered" style="display:none">
	<thead>
          <p align="center" class="psales" style="display:none"> <b> All User Sales  </b></p>
			<tr>
				<th width="50%">Date</th>
				<th width="50%">QTY</th>
				<th width="50%">Price</th>
			</tr>
			</thead>
			<tbody>
				<?php
				foreach($sales_all as $report)
				{
				?>
					<tr>
					<td><?php echo $report['sale_time']; ?></td>
					<td><?php echo $report['quantity_purchased']; ?></td>
					<td><?php echo $report['item_unit_price']; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
 
<p class="cos2">Cost History - Avarage Cost - Minimum Price</p>
<p class="cos3" style="display:none"> Avarage Cost is : <?php echo $cost; ?> - Minimum Price is : <?php echo $minimum_price; ?> </p>
 
 
  <table class="table table-cost table-bordered" style="display:none">
	<thead>
			<tr>
				<th width="50%">Date</th>
				<th width="50%">QTY</th>
				<th width="50%">Price</th>
			</tr>
			</thead>
			<tbody>
				<?php
				foreach($costs as $report)
				{
				?>
					<tr>
					<td><?php echo $report['receiving_time']; ?></td>
					<td><?php echo $report['quantity_purchased']; ?></td>
					<td><?php echo $report['item_unit_price']; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>