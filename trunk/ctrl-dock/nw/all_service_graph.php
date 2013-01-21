	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		<?
			echo $graph_data;
		?>
        ]);

        var options = {
		  height: 150,
          greenFrom: 90, greenTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks:5
        };

        var chart = new google.visualization.Gauge(document.getElementById('<?=$graph_name;?>'));
        chart.draw(data, options);
      }
    </script>
    <div id="<?=$graph_name;?>" align="center"></div>
