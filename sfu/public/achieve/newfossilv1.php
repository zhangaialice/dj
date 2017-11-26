
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>


<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>

<style>
html, body { height: 100%; padding: 0; margin: 0; }

#TF{ width: 100%;}
#div1 { background: white; text-align: center;}
#div2 { background: white; text-align: center;}
#div3 { background: white; text-align: center;}
#div4 { background: white; text-align: center;}

label {
font-size: 20;
}


#content{position: fixed;
top:100px;

}

#content div {
    float:left;
    width:45%;
    height:400px;
    background: transparent;
    display:inline-block;
  }


</style>


</head>
<body>


<?php include("../includes/dropdown.php"); ?>



<div id="content">
<img  class="divider" src="image/divider.png" height="20" width="1600">



			<div id="div1">

			<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Exposure Percentage - By Manager</label>
			</br>
				<canvas id="myChart" width="5" height="5"></canvas>

				<?php include("../includes/sql_connect.php");?>

					<?php
						// 2. Perform database query
						$query  = "SELECT * ";
						$query .= "FROM fossil_manager ";
						$result = mysqli_query($connection, $query);
						$datas=array();
						// Test if there was a query error
						if (mysqli_num_rows($result)>0) {
						while($row = mysqli_fetch_assoc($result)) {
						$manager[]=$row['Manager'];
						$pv_2014[]=$row['FossilFuel_2014'];
						$pv_2015[]=$row['FossilFuel_2015'];
						$pv_2016[]=$row['FossilFuel_2016'];
						$data_2014[]=$row['Percentage_2014'];
						$data_2015[]=$row['Percentage_2015'];
						$data_2016[]=$row['Percentage_2016'];
						$num_2014[]=$row['Number_2014'];
						$num_2015[]=$row['Number_2015'];
						$num_2016[]=$row['Number_2016'];
						}}
					
					//the following code is used for testing the json data format conversion	
					$a=json_encode($datas);
					$p_2014 = json_encode($data_2014);
					$p_2015 = json_encode($data_2015);
					$p_2016 = json_encode($data_2016);
					$n_2014 = json_encode($num_2014);
					$n_2015 = json_encode($num_2015);
					$n_2016 = json_encode($num_2016);
					$fp_2014=str_replace(array("'", "\"", "&quot;"),"",$p_2014);
					$fp_2015=str_replace(array("'", "\"", "&quot;"),"",$p_2015);
					$fp_2016=str_replace(array("'", "\"", "&quot;"),"",$p_2016);
					$fp_2014=str_replace(array("'", "\"", "&quot;"),"",$n_2014);
					$fp_2015=str_replace(array("'", "\"", "&quot;"),"",$n_2015);
					$fp_2016=str_replace(array("'", "\"", "&quot;"),"",$n_2016);
					?>
			<?php array_pop($manager); ?>
			
			<?php
			
			$loop_arr=array("2014","2015","2016");
			
			for ($i = 0; $i <= 2; $i++) { 
			
			
			//print_r($pv_2015);

			//print_r($manager);
			//print_r(end($pv_2016))."/br";
			//echo gettype($datas);

			foreach (${'pv_'.$loop_arr[$i]} as $value) {

			${'new_pv_'.$loop_arr[$i]}[] = $value/end(${'pv_'.$loop_arr[$i]});//change year
			};
			
			
			array_pop(${'new_pv_'.$loop_arr[$i]});
			
			//print_r ($new_pv_2016);
			
			${'asso_pv_'.$loop_arr[$i]} = array_combine($manager, ${'new_pv_'.$loop_arr[$i]});
			//print_r($test)."<br/>";
			${'asso1_pv_'.$loop_arr[$i]} =array();//-change associate array name
			foreach(${'asso_pv_'.$loop_arr[$i]} as $label => $value)
			{array_push(${'asso1_pv_'.$loop_arr[$i]}, array("y"=>$value,"label"=>$label));}		
			//print_r (${'asso1_pv_'.$loop_arr[$i]});
			
			?>
		
	
	
<script type="text/javascript">

//window.onload = function () {
	
	var chart = new CanvasJS.Chart("asso1_pv_2014",
	{
		title:{
			text: "Allocation of Fossoil Fuel Exposure between Managers"
		},
		exportFileName: "Pie Chart",
		exportEnabled: true,
                animationEnabled: true,
		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},
		data: [
		{       
			type: "pie",
			showInLegend: false,
			toolTipContent: "{label}: <strong>{y}</strong>",
			indexLabel: "{label} {y}",
			dataPoints: 
			<?php echo json_encode($$test[$i],JSON_NUMERIC_CHECK); ?>
			
	}
	]
	
	});
	chart.render();

//}


</script>

</body>	

			
			
		