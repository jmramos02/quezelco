$(document).ready(function(){
	var ctx = document.getElementById("myChart").getContext("2d");

	//get shit data from ajax
	$.ajax({
		type : "GET",
		url : "ajax/customer-status",
		dataType : 'json'
	}).done(function(response){
		var data = [
			    {
			        value: response[0],
			        color:"#26A65B",
			        highlight: "yellow",
			        label: "Connected"
			    },
			    {
			        value: response[1],
			        color: "red",
			        highlight: "orange",
			        label: "Disconnected"
			    }
		];	
		var myDoughnutChart = new Chart(ctx).Doughnut(data);
	}).error(function(err,status,errorThrown){
		alert(errorThrown);
	});


	//for bargraphh

	var ctx2 = document.getElementById("bill-status").getContext("2d");
	$.ajax({
		type : "GET",
		url : "ajax/bill-status",
		dataType : 'json'
	}).done(function(response){
		var data = {
		    labels: ["Paid", "Not Yet Paid", "Penalty", "For Disconnection"],
		    datasets: [
		        {
		            label: "Bill Status",
		            fillColor: "rgba(220,220,220,0.5)",
		            strokeColor: "rgba(220,220,220,0.8)",
		            highlightFill: "rgba(220,220,220,0.75)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: response
		        },
		    ]
		};
		var myBarChart = new Chart(ctx2).Bar(data);

	}).error(function(err,status,errorThrown){
		alert(errorThrown);
	});
});