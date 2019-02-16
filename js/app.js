$(document).ready(function(){
	$.ajax({
		url: "http://localhost/my-test/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
                        var cc = [];
                        var value = [];

			for(var i in data) {
                                cc.push(data[i].Year);
                                value.push(data[i].NewSignUps);
			}

			var chartdata = {
				labels: cc,
				datasets : [
                                    {
					label: 'Number of sign-ups',
					backgroundColor: 'rgba(0,191,255, 0.75)',
					borderColor: 'rgba(0,191,255, 0.75)',
					hoverBackgroundColor: 'rgba(0,191,255, 1)',
					hoverBorderColor: 'rgba(0,191,255, 1)',
					data: value
                                    }
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});
