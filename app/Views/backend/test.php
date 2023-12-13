<div class="page-wrapper">
   
<div id="echart_test"  style="height: 310px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;">

</div>
</div>

<script>
    	if ($('#echart_test').length > 0) {
    var total_sale_chart = echarts.init(document.getElementById('echart_test'));

    var currentMonth = ['Jan', 'Feb', 'Mar', 'Apr'];

    var option = {
        xAxis: {
            type: 'category',
            data: currentMonth
        },
        yAxis: {},
        series: [
            {
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                type: 'line',
                label: {
                    show: true,
                    position: 'top',
                    formatter: '{c}', // Display the value of the data point as the label
                    color: 'rgba(0, 47, 255, 0.95)',
                    distance: 5 // Adjust the distance from the data point
                }
            }
        ]
    };

    total_sale_chart.setOption(option);
    total_sale_chart.resize();
}

</script>