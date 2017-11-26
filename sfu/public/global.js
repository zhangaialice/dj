$('input#year1_submit').on('click', function(){ 
	var year1=$('input#year1').val();
	if (year1 !=''){$.post("global.php"),{year1:year1}, function(data){alert(data);}}
});
//if (year1 !=''){$.post("global.php"),{year1:year1}, function(data){alert(data);}}