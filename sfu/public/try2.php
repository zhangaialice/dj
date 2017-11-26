<!doctype html>

<html>

<head>

</head>

<div id="map_canvas" class="flex-video">testt</div>

<input type="button" class="secondary small radius button right" name="btnmap" id="btnmap" value="Hide Map" />

<script>
$(document).ready(function(e) {
    $('#btnmap').click(function(e) {
        $('#map_canvas').toggle('fast');
        if($('#btnmap').val()=='Hide Map'){
            $('#btnmap').val('Show map');
        }
        else{
            $('#btnmap').val('Hide Map');
            }
    });
});
</script>
</body>

</html>