export const profitChartData = {
    type: "line",
    data: {
      labels: ["January", "February", "March", "April", "May", "June", "July", "August","September","October"],
      datasets: [
        {
          label: "Sales",
          data: [200, 200, 122, 207, 790, 822.5, 270.5, 141, 600, 550],
          backgroundColor: "rgba(54,73,93,.5)",
          borderColor: "#36495d",
          borderWidth: 3
        },
        {
          label: "Cost",
          data: [166, 208.1, 300.3, 0.323, 954.792, 285.886, 43.662, 51.514, 49.90, 700.65],
          backgroundColor: "rgba(71, 183,132,.5)",
          borderColor: "#47b784",
          borderWidth: 3
        }
      ]
    },
    options: {
      title:{
        display:true,
        text: 'Monthly Farm Report'

      },
      legend:{
        display:'true',
        position: 'right'
      },
      layout:{
        padding:{
          left: 0,
          right: 0,
          top: 0,
          bottom: 0
        } 
        
      },
      responsive: true,
      lineTension: 1,
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              padding: 25
            }
          }
        ]
      }
    }
  };
  
  export default profitChartData;