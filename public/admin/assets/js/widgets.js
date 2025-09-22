
  "use strict";

  /* Total Applications */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },

    series: [85],
    colors: ["rgb(112, 94, 200)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff"
        },
        dataLabels: {
          name: {
            offsetY: -10,
            color: "#4b9bfa",
            fontSize: "10px",
            show: false
          },
          value: {
            offsetY: 5,
            color: "#4b9bfa",
            fontSize: "12px",
            show: true,
            fontWeight: 800
          }
        }
      }
    },
    stroke: {
      lineCap: "round"
    },
    labels: ["Followers"]
  };
  var chart5 = new ApexCharts(document.querySelector("#total-applications"), options);
  chart5.render();
  /* Total Applications */

  /* Shortlisted */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },
    series: [60],
    colors: ["rgb(56, 204, 137)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff"
        },
        dataLabels: {
          name: {
            offsetY: -10,
            color: "#4b9bfa",
            fontSize: "10px",
            show: false
          },
          value: {
            offsetY: 5,
            color: "#4b9bfa",
            fontSize: "12px",
            show: true,
            fontWeight: 800
          }
        }
      }
    },
    stroke: {
      lineCap: "round"
    },
    labels: ["Followers"]
  };
  var chart5 = new ApexCharts(document.querySelector("#shortlisted"), options);
  chart5.render();
  /* Shortlisted */

  /* Rejected */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },
    series: [25],
    colors: ["rgb(251, 28, 82)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff"
        },
        dataLabels: {
          name: {
            offsetY: -10,
            color: "#4b9bfa",
            fontSize: "10px",
            show: false
          },
          value: {
            offsetY: 5,
            color: "#4b9bfa",
            fontSize: "12px",
            show: true,
            fontWeight: 800
          }
        }
      }
    },
    stroke: {
      lineCap: "round"
    },
    labels: ["Followers"]
  };
  var chart5 = new ApexCharts(document.querySelector("#rejected"), options);
  chart5.render();
  /* Rejected */

  /* Total Revenue */
  var spark1 = {
    chart: {
      type: 'area',
      height: 60,
      width: 150,
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 0,
        left: 0,
        blur: 3,
        color: '#000',
        opacity: 0.1
      }
    },
    stroke: {
      show: true,
      curve: 'smooth',
      lineCap: 'butt',
      colors: undefined,
      width: 1.5,
      dashArray: 0,
    },
    fill: {
      gradient: {
        enabled: false
      }
    },
    series: [{
      name: 'Value',
      data: [0, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46]
    }],
    yaxis: {
      min: 0,
      show: false
    },
    xaxis: {
      axisBorder: {
        show: false
      },
    },
    yaxis: {
      axisBorder: {
        show: false
      },
    },
    colors: ['rgb(112, 94, 200)'],

  }
  var spark1 = new ApexCharts(document.querySelector("#total-revenue"), spark1);
  spark1.render();
  /* Total Revenue */

  /* Unique Visitors */
  var spark2 = {
    chart: {
      type: 'area',
      height: 60,
      width: 150,
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 0,
        left: 0,
        blur: 3,
        color: '#000',
        opacity: 0.1
      }
    },
    stroke: {
      show: true,
      curve: 'smooth',
      lineCap: 'butt',
      colors: undefined,
      width: 1.5,
      dashArray: 0,
    },
    fill: {
      gradient: {
        enabled: false
      }
    },
    series: [{
      name: 'Value',
      data: [0, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46]
    }],
    yaxis: {
      min: 0,
      show: false
    },
    xaxis: {
      axisBorder: {
        show: false
      },
    },
    yaxis: {
      axisBorder: {
        show: false
      },
    },
    colors: ['rgb(56, 204, 137)'],

  }
  var spark2 = new ApexCharts(document.querySelector("#unique-visitors"), spark2);
  spark2.render();
  /* Unique Visitors */

  /* Expenses */
  var spark3 = {
    chart: {
      type: 'area',
      height: 60,
      width: 150,
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 0,
        left: 0,
        blur: 3,
        color: '#000',
        opacity: 0.1
      }
    },
    stroke: {
      show: true,
      curve: 'smooth',
      lineCap: 'butt',
      colors: undefined,
      width: 1.5,
      dashArray: 0,
    },
    fill: {
      gradient: {
        enabled: false
      }
    },
    series: [{
      name: 'Value',
      data: [0, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46]
    }],
    yaxis: {
      min: 0,
      show: false
    },
    xaxis: {
      axisBorder: {
        show: false
      },
    },
    yaxis: {
      axisBorder: {
        show: false
      },
    },
    colors: ['rgb(251, 28, 82)'],

  }
  var spark3 = new ApexCharts(document.querySelector("#expenses"), spark3);
  spark3.render();
  /* Expenses */

 //sparkline_bar11
var sparkbar1 = {
  chart: {
    type: "bar",
    height: 50,
    barWidth: 5,
    barSpacing: 7,
    sparkline: {
      enabled: true,
    },
    dropShadow: {
      enabled: false,
      blur: 3,
      opacity: 0.2,
    },
  },
  stroke: {
    show: true,
    curve: "smooth",
    lineCap: "butt",
    colors: undefined,
    width: 2,
    dashArray: 0,
  },
  fill: {
    gradient: {
      enabled: false,
    },
  },
  series: [
    {
      name: "Total Revenue",
      data: [
        2, 4, 3, 4, 5, 4, 5, 3, 4, 5, 2, 4, 5, 4, 3, 5, 4, 3, 4, 5, 4, 5, 4, 3,
        5, 4, 3, 4, 5,
      ],
    },
  ],
  yaxis: {
    min: 0,
  },
  colors: ["#4454c3"],
};
var sparkbar1 = new ApexCharts(
  document.querySelector("#sparkline_bar11"),
  sparkbar1
);
sparkbar1.render();
//sparkline_bar11

//sparkline_bar12
var sparkbar2options = {
  chart: {
    type: "bar",
    height: 50,
    barWidth: 5,
    barSpacing: 7,
    sparkline: {
      enabled: true,
    },
    dropShadow: {
      enabled: false,
      blur: 3,
      opacity: 0.2,
    },
  },
  stroke: {
    show: true,
    curve: "smooth",
    lineCap: "butt",
    colors: undefined,
    width: 2,
    dashArray: 0,
  },
  fill: {
    gradient: {
      enabled: false,
    },
  },
  series: [
    {
      name: "Total Revenue",
      data: [
        3, 5, 4, 4, 5, 4, 5, 3, 4, 5, 3, 4, 5, 4, 3, 5, 4, 3, 4, 5, 4, 5, 4, 3,
        5, 4, 3, 4, 5,
      ],
    },
  ],
  yaxis: {
    min: 0,
  },
  colors: ["rgb(251, 28, 82)"],
};
var sparkbar2 = new ApexCharts(
  document.querySelector("#sparkline_bar12"),
  sparkbar2options
);
sparkbar2.render();
//sparkline_bar12

//sparkline_bar13
var sparkbar3 = {
  chart: {
    type: "bar",
    height: 50,
    barWidth: 5,
    barSpacing: 7,
    sparkline: {
      enabled: true,
    },
    dropShadow: {
      enabled: false,
      blur: 3,
      opacity: 0.2,
    },
  },
  stroke: {
    show: true,
    curve: "smooth",
    lineCap: "butt",
    colors: undefined,
    width: 2,
    dashArray: 0,
  },
  fill: {
    gradient: {
      enabled: false,
    },
  },
  series: [
    {
      name: "Total Revenue",
      data: [
        3, 5, 4, 4, 5, 4, 5, 3, 4, 5, 3, 4, 5, 4, 3, 5, 4, 3, 4, 5, 4, 5, 4, 3,
        5, 4, 3, 4, 5,
      ],
    },
  ],
  yaxis: {
    min: 0,
  },
  colors: ["rgb(56, 204, 137)"],
};
var sparkbar3 = new ApexCharts(
  document.querySelector("#sparkline_bar13"),
  sparkbar3
);
sparkbar3.render();
//sparkline_bar13

//sparkline_bar14
var sparkbar4 = {
  chart: {
    type: "bar",
    height: 50,
    barWidth: 5,
    barSpacing: 7,
    sparkline: {
      enabled: true,
    },
    dropShadow: {
      enabled: false,
      blur: 3,
      opacity: 0.2,
    },
  },
  stroke: {
    show: true,
    curve: "smooth",
    lineCap: "butt",
    colors: undefined,
    width: 2,
    dashArray: 0,
  },
  fill: {
    gradient: {
      enabled: false,
    },
  },
  series: [
    {
      name: "Total Revenue",
      data: [
        3, 5, 4, 4, 5, 4, 5, 3, 4, 5, 3, 4, 5, 4, 3, 5, 4, 3, 4, 5, 4, 5, 4, 3,
        5, 4, 3, 4, 5,
      ],
    },
  ],
  yaxis: {
    min: 0,
  },
  colors: ["rgb(92, 127, 255)"],
};
var sparkbar4 = new ApexCharts(
  document.querySelector("#sparkline_bar14"),
  sparkbar4
);
sparkbar4.render();
//sparkline_bar13

  /*----CryptoChart----*/
  var ctx = document.getElementById("CryptoChart");
  var myChart2 = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"],
      type: "line",
      datasets: [
        {
          data: [83, 56, 89, 73, 61, 75, 86, 56],
          label: "Bitcon",
          backgroundColor: "rgb(112, 94, 200,0.06)",
          borderColor: "rgba(112, 94, 200,0.6)",
          fill: true,
          borderWidth: "3",
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          lineTension: 0.3,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      plugins: {
        legend: {
          display: false,
          labels: {
            display: false,
          },
        },
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  /*----End CrptoChart----*/

  /*----CryptoChart11----*/
  var ctx = document.getElementById("CryptoChart1");
  var myChart1 = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"],
      type: "line",
      datasets: [
        {
          data: [45, 78, 67, 78, 36, 78, 89, 84],
          label: "Nem",
          backgroundColor: "rgb(112, 94, 200,0.06)",
          borderColor: "rgba(112, 94, 200,0.6)",
          fill: true,
          borderWidth: "3",
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          lineTension: 0.3,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      plugins: {
        legend: {
          display: false,
          labels: {
            display: false,
          },
        },
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  /*----En d CrptoChart1----*/

  /*----CryptoChart2----*/
  var ctx = document.getElementById("CryptoChart2");
  var myChart3 = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"],
      type: "line",
      datasets: [
        {
          data: [56, 78, 36, 78, 29, 78, 37, 56],
          label: "Ripple",
          backgroundColor: "rgb(112, 94, 200,0.06)",
          borderColor: "rgba(112, 94, 200,0.6)",
          fill: true,
          borderWidth: "3",
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          lineTension: 0.3,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      plugins: {
        legend: {
          display: false,
          labels: {
            display: false,
          },
        },
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  /*----End CrptoChart2----*/

  /*----CryptoChart3----*/
  var ctx = document.getElementById("CryptoChart3");
  var myChart4 = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"],
      type: "line",
      datasets: [
        {
          data: [45, 78, 98, 34, 67, 28, 89, 45],
          label: "Neo",
          backgroundColor: "rgb(112, 94, 200,0.06)",
          borderColor: "rgba(112, 94, 200,0.6)",
          fill: true,
          borderWidth: "3",
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          lineTension: 0.3,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      plugins: {
        legend: {
          display: false,
          labels: {
            display: false,
          },
        },
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  /*----End CrptoChart3----*/

  /* Start Shares */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },

    series: [65],
    colors: ["rgb(112, 94, 200)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff",
        },
        dataLabels: {
          name: {
            show: false,
          },
          value: {
            offsetY: 10,
            offsetX: 10,
            color: "#4b9bfa",
            fontSize: "1.25rem",
            show: false,
          },
        },
      },
    },
    stroke: {
      lineCap: "round",
    },
    labels: ["Followers"],
  };
  var shares = new ApexCharts(document.querySelector("#shares"), options);
  shares.render();
  /* End Shares */

  /* Start Projects */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },

    series: [60],
    colors: ["rgb(251, 28, 82)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff",
        },
        dataLabels: {
          name: {
            show: false,
          },
          value: {
            offsetY: 10,
            offsetX: 10,
            color: "#4b9bfa",
            fontSize: "1.25rem",
            show: false,
          },
        },
      },
    },
    stroke: {
      lineCap: "round",
    },
    labels: ["Followers"],
  };
  var projects = new ApexCharts(document.querySelector("#projects"), options);
  projects.render();

  /* End Projects */
  /* Start Users */
  var options = {
    chart: {
      height: 150,
      width: 150,
      type: "radialBar",
    },

    series: [60],
    colors: ["rgb(56, 204, 137)"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "60%",
          background: "#fff",
        },
        dataLabels: {
          name: {
            show: false,
          },
          value: {
            offsetY: 10,
            offsetX: 10,
            color: "#4b9bfa",
            fontSize: "1.25rem",
            show: false,
          },
        },
      },
    },
    stroke: {
      lineCap: "round",
    },
    labels: ["Followers"],
  };
  var users = new ApexCharts(document.querySelector("#users"), options);
  users.render();

  /* End Users */
