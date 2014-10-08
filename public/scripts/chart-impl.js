$(document).ready(function(){
	var ctx = $("#myChart").get(0).getContext("2d");
	Chart.defaults.global.responsive = true;

	//get shit data from ajax

	var data = [];
	$.ajax({
		type : "GET",
		url : "ajax/payments-annual/2014",
		dataType : 'json'
	}).done(function(response){
		data = response;
		var data = {
	    labels: ["January", "February", "March", "April", "May", "June", "July",'August','September','October','November','December'],
		    datasets: [
		        {
		            label: "My First dataset",
		            fillColor: "rgba(220,220,220,0.2)",
		            strokeColor: "rgba(220,220,220,1)",
		            pointColor: "rgba(220,220,220,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: data
		        },
		    ]
		};


		var myLineChart = new Chart(ctx).Line(data,{
			scaleGridLineColor : "rgba(0,0,0,.05)",
			scaleGridLineWidth : 1,
		});
	}).error(function(err,status,errorThrown){
		alert(errorThrown);
	});
});