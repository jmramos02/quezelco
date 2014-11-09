$(document).ready(function(){
	loadAll();
	$(".location-button").click(function(){
		loadAll();
	});
});

function loadAll(){
	var location = $('.location').val();
	var ctx = document.getElementById("myChart").getContext("2d");
	
	//get shit data from ajax
	$.ajax({
		type : "GET",
		url : "ajax/customer-status",
		data : {location : location},
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
		alert('Zero record found!');
	});

	//for bargraphh

	var ctx2 = document.getElementById("bill-status").getContext("2d");
	$.ajax({
		type : "GET",
		url : "ajax/bill-status",
		data : {location : location},
		dataType : 'json'
	}).done(function(response){
		var data = {
		    labels: ["Paid", "Not Yet Paid", "Penalty", "For Disconnection"],
		    datasets: [
		        {
		            label: "Bill Status",
		            fillColor: "#26A65B",
		            strokeColor: "#26A65B",
		            highlightFill: "rgba(220,220,220,0.75)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: response
		        },
		    ]
		};
		var myBarChart = new Chart(ctx2).Bar(data);

	}).error(function(err,status,errorThrown){
		alert('Zero record found!');
	});

	var ctx3 = document.getElementById("payment-history").getContext("2d");

	$.ajax({
		type : "GET",
		url : "ajax/payments-annual/2014",
		data : {location : location},
		dataType : 'json'
	}).done(function(response){
		
		var data = {
		    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		    datasets: [
				        {
				            label: "Payment History",
				            fillColor: "rgba(220,220,220,0.2)",
				            strokeColor: "#26A65B",
				            pointColor: "rgba(220,220,220,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(220,220,220,1)",
				            data: response
				        },
				    ]
				};
		var myLineChart = new Chart(ctx3).Line(data,{
			responsive: true
		});

	}).error(function(err,status,errorThrown){
		alert('Zero record found!');
	});
}