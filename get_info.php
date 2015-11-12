<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include dirname( __FILE__ ) . "/config/config.php";
include dirname( __FILE__ ) . "/helpers/init_db_conex.php";

function decimal_to_rgb($int) {
    $max_value = 16777215;
    while($int > $max_value){
        $int = $int - $max_value;
    }

    return str_pad(dechex($int),6,"0",STR_PAD_LEFT);
}


    $data = $db_connect->query(" SELECT * FROM data ORDER BY date DESC; ");
?>
<html>
<head>
    <title>Money Tracker - Data</title>
    <style type="text/css">
    .canvas-wrapper {
      width: 100%;
      height: auto;
      padding-bottom: 50%;
      margin: 10px 5%;
      position:relative;
    }
    #charts{
        position: absolute;
        width: 100%;
        height: 100%;
    }
    </style>
</head>
<body>
    <div class="canvas-wrapper">
        <canvas id="charts" ></canvas>
    </div>
<?php

    

    $charting_data = array();
    if ( !empty( $data ) ){

        echo "<table border=1>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                if ( $key == 'date' ) {
                    // $value = "<script>date = new Date({$value}000); document.write(date) </script>";
                    $value = date("Y-m-d H:i:s",$value);
                }
                echo "<td>$value</td>";
            }
            echo "</tr>";

            if(isset($charting_data[$row['label']])) {
                $charting_data[$row['label']]['value'] += $row['amount'];
            } else {
                $charting_data[$row['label']] = array(
                    "value"=> $row['amount'],
                    "label"=> $row['label']
                );
            }
        }

        echo "</table>";

    }

    $chart_array = array();
    $color_shift = 16777215/count($charting_data);
    $color = 0;
    foreach ($charting_data as $key => $value) {
        $value['color'] = "#".decimal_to_rgb($color+=$color_shift);
        $value['highlight'] = "#".decimal_to_rgb($color-$color_shift/2);
        $chart_array[] = $value;
    }
    #print_r($chart_array)
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js"></script>
<script type="text/javascript">
window.onload = function(){
    var ctx = document.getElementById('charts').getContext("2d");
    var data = <?php echo json_encode($chart_array); ?>;
    var options = {};
    var myPieChart = new Chart(ctx).Pie(data,options);
}
</script>
</body>
</html>
