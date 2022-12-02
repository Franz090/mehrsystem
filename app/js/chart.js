// pie chart
var ctx = document.getElementById("patients").getContext("2d");
var infant = document.getElementById("infant").getContext("2d");
var myChart_patients = new Chart(ctx, {
	type: "polarArea",
	data: {
		labels: labels_patients,
		datasets: [
			{
				label: "# of Patients per Barangay",
				data: data_patients,
				backgroundColor: [
					"rgba(255, 99, 132, 1)",
					"rgba(54, 162, 235, 1)",
					"rgba(255, 206, 86, 1)",
					"rgba(75, 192, 192, 1)",
					"rgba(153, 102, 255, 1)",
					"rgba(255, 159, 64, 1)",
				],
			},
		],
	},
	options: {
		responsive: true,
	},
});
// bar chart
var myChart_infant = new Chart(infant, {
	type: "bar",
	data: {
		labels: labels_infant_records,
		datasets: [
			{
				label: "# of Vaccinated",
				data: data_infant_records,
				backgroundColor: [
					"rgba(75, 192, 192, 1)",
					"rgba(255, 19, 69, 1)",
					"rgba(255, 99, 132, 1)",
					"rgba(54, 162, 235, 1)",
					"rgba(255, 206, 86, 1)",
					"rgba(153, 102, 255, 1)",
					"rgba(255, 159, 64, 1)",
				],
			},
		],
	},
	options: {
		responsive: true,
	},
});
