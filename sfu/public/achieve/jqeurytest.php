<!DOCTYPE HTML>
<html>

<head>  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<?php

$datas=["Italy","China","France","Great Britain","Soviet Union","USA"];
$data_2014=[198,201,202,236,395,957];
$c = array_combine($datas,$data_2014);
print_r($c);
?>
<?php

$y=[221,201,105,98,98,88];

$l=["Italy","China","Great Britain","France","Soviet Union","USA"];
$ai = array_combine($l,$y);

$datapoints =array();
foreach($ai as $label => $value)
{$datapoints[]= array("y"=>$value,"label"=>$label);}


		
?>
</pre>
<pre>
<?php echo json_encode($c) ?>
</pre>
 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript">
	var test = <?php echo json_encode($c) ?>;
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Olympic Medals of all Times (till 2012 Olympics)"
      },
      animationEnabled: true,
      legend: {
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
          }
          else {
              e.dataSeries.visible = true;
          }
          chart.render();
        }
      },
      axisY: {
        title: "Medals"
      },
      toolTip: {
        shared: true,  
        content: function(e){
          var str = '';
          var total = 0 ;
          var str3;
          var str2 ;
          for (var i = 0; i < e.entries.length; i++){
            var  str1 = "<span style= 'color:"+e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ; 
            total = e.entries[i].dataPoint.y + total;
            str = str.concat(str1);
          }
          str2 = "<span style = 'color:DodgerBlue; '><strong>"+e.entries[0].dataPoint.label + "</strong></span><br/>";
          str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";
          
          return (str2.concat(str)).concat(str3);
        }

      },
      data: [
      {        
        type: "bar",
        showInLegend: true,
        name: "Gold",
        color: "gold",
        dataPoints: 
		<?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>


      },
      {        
        type: "bar",
        showInLegend: true,
        name: "Silver",
        color: "silver",          
        dataPoints: [
        { y: 166, label: "Italy"},
        { y: 144, label: "China"},
        { y: 223, label: "France"},        
        { y: 272, label: "Great Britain"},        
        { y: 319, label: "Soviet Union"},        
        { y: 759, label: "USA"}        


        ]
      },
      {        
        type: "bar",
        showInLegend: true,
        name: "Bronze",
        color: "#A57164",
        dataPoints: [
        { y: 185, label: "Italy"},
        { y: 128, label: "China"},
        { y: 246, label: "France"},        
        { y: 272, label: "Great Britain"},        
        { y: 296, label: "Soviet Union"},        
        { y: 666, label: "USA"}    

        ]
      }

      ]
    });

chart.render();
}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script></head>
<body>
  <div id="chartContainer" style="height: 300px; width: 30%;">
  </div>
</body>

</html>