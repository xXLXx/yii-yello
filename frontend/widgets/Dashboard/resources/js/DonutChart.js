var DonutChart = {
    draw: function(title, items) {
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var colors = [];
            var data = new google.visualization.DataTable();
            data.addColumn('string', title);
            data.addColumn('number', 'Count');
            for (var i in items) {
                data.addRow([items[i].title, items[i].count]);
                colors.push(items[i].color);
            }
            var options = {
                legend:'none',
                pieHole: 0.3,
                colors: colors,
                chartArea: {
                    width: 300,
                    height: 300
                },
                pieSliceText: 'none'
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart' + title));
            chart.draw(data, options);
        }
    }
}