    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('datetime', 'Time');
		data.addColumn('number', 'Min');
		data.addColumn('number', 'Avg');
		data.addColumn('number', 'Max');
        data.addRows([
		  <?
			echo $graph_data;
		  ?>
        ]);

        var options = {
          title: '<?=$graph_title;?>',
          vAxis: {title: "<?=$y_axis_label;?>"},
		  hAxis: {title: "<?=$x_axis_label;?>"}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('<?=$graph_name;?>'));
        chart.draw(data, options);
      }
    </script>
    <div id="<?=$graph_name;?>" style="width: <?=$graph_width;?>; height: <?=$graph_height?>;"></div>
