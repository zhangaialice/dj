<!DOCTYPE html>
<html>
<head>
<div class="results"></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<div id="output"></div>
<?php

$datas=["Italy","China","France","Great Britain","Soviet Union","USA"];
$data_2014=[198,201,202,236,395,957];
$c = array_combine($datas,$data_2014);

?>

<pre>
<?php echo json_encode($c) ?>
</pre>


  <?php
        $dataPoints = array(
            array("y" => 6, "label" => "Apple"),
            array("y" => 4, "label" => "Mango"),
            array("y" => 5, "label" => "Orange"),
            array("y" => 7, "label" => "Banana"),
            array("y" => 4, "label" => "Pineapple"),
            array("y" => 6, "label" => "Pears"),
            array("y" => 7, "label" => "Grapes"),
            array("y" => 5, "label" => "Lychee"),
            array("y" => 4, "label" => "Jackfruit")
        );
    echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
    ?>
<script type="text/javascript">

var test = <?php echo json_encode($c) ?>;// don't use quotes
$.each(test, function(key, value) {
    console.log('{ y:' + value + ', label: ' +'"'+ key+ '"},');
});

document.write(console.log("hi"));

var output = document.getElementById("output");
output.innerHTML = "hello world";
</script>



		$.each(test, function(key, value) {
			console.log('{ y:' + value + ', label: ' +'"'+ key+ '"},');
		});

<?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2014));?>

<?php print json_encode($data_2014)[0];?>


<?php

$y=[221,201,105,98,98,88];

$l=["Italy","China","Great Britain","France","Soviet Union","USA"];
$ai = array_combine($l,$y);

$datapoints =array();
foreach($ai as $label => $value)
{$datapoints[]= array("key"=>$value,"label"=>$label);}

print_r($datapoints);		
?>




y=[201,201,105,98,88,88];

l=["Italy","China","Great Britain","France","Soviet Union","USA"];
		$datapoints = [
            array("y" => 201, "label" => "Italy"),
            array("y" => 201, "label" => "China"),
            array("y" => 105, "label" => "Great Britain"),
            array("y" => 98, "label" => "France"),
            array("y" => 88, "label" => "Soviet Union"),
			array("y" => 88, "label" => "USA")];	
