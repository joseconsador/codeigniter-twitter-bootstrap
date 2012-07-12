$(document).ready(function () {
	$('select[name="branch_id"], select[name="date_range"]').change(function () {
		$.ajax({
			url: BASE_URL + 'orders/get_sales',
			type: 'post',
			data: $('select[name="branch_id"], select[name="date_range"]').serialize(),
			dataType: 'json',
			success: function (response) {
				if (response) {					
					drawSalesChart(response.response, response.branches);
				}
			}
		});
	});

	$('select[name="branch_id"]').trigger('change');	
});

function drawSalesChart(sales, branches) {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Date');
	data.addColumn('number', 'Sales');

	var row_ctr = 0;
	$.each(sales, function (date, orders) {		
			data.addRow([date, orders]);		
	});

	var options = {
	  title: 'Branch Sales',
	  vAxis: {title: 'Amount',  titleTextStyle: {color: 'red'}}
	};

	var chart = new google.visualization.LineChart(document.getElementById('sales_chart_div'));
	chart.draw(data, options);
}	
