$((function(e) {
    "use strict";
    var t = document.getElementById("areaChart1").getContext("2d");
    new Chart(t, { type: "line", data: { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], type: "line", datasets: [{ label: "Total Quantity", data: [30, 70, 30, 100, 50, 130, 100, 140], backgroundColor: "transparent", borderColor: "#0774f8", pointBackgroundColor: "#0774f8", pointHoverBackgroundColor: "#0774f8", pointBorderColor: "#0774f8", pointHoverBorderColor: "#0774f8", pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 2, borderWidth: 3 }] }, options: { maintainAspectRatio: !1, legend: { display: !1 }, responsive: !0, tooltips: { mode: "index", titleFontSize: 12, titleFontColor: "#6b6f80", bodyFontColor: "#6b6f80", backgroundColor: "#fff", titleFontFamily: "Montserrat", bodyFontFamily: "Montserrat", cornerRadius: 3, intersect: !1 }, scales: { xAxes: [{ gridLines: { color: "transparent", zeroLineColor: "transparent" }, ticks: { fontSize: 2, fontColor: "transparent" } }], yAxes: [{ display: !1, ticks: { display: !1 } }] }, title: { display: !1 }, elements: { line: { borderWidth: 1 }, point: { radius: 4, hitRadius: 10, hoverRadius: 4 } } } }), 
    t = document.getElementById("areaChart2").getContext("2d"), 
    new Chart(t, { type: "line", data: { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], type: "line", datasets: [{ label: "Total Cost", data: [24, 18, 28, 21, 32, 28, 30], backgroundColor: "transparent", borderColor: "#d43f8d", pointBackgroundColor: "#d43f8d", pointHoverBackgroundColor: "#d43f8d", pointBorderColor: "#d43f8d", pointHoverBorderColor: "#d43f8d", pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 2, borderWidth: 3 }] }, options: { maintainAspectRatio: !1, legend: { display: !1 }, responsive: !0, tooltips: { mode: "index", titleFontSize: 12, titleFontColor: "#6b6f80", bodyFontColor: "#6b6f80", backgroundColor: "#fff", titleFontFamily: "Montserrat", bodyFontFamily: "Montserrat", cornerRadius: 3, intersect: !1 }, scales: { xAxes: [{ gridLines: { color: "transparent", zeroLineColor: "transparent" }, ticks: { fontSize: 2, fontColor: "transparent" } }], yAxes: [{ display: !1, ticks: { display: !1 } }] }, title: { display: !1 }, elements: { line: { borderWidth: 1 }, point: { radius: 4, hitRadius: 10, hoverRadius: 4 } } } }), 
    t = document.getElementById("areaChart3").getContext("2d"), 
    new Chart(t, { type: "line", data: { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], type: "line", datasets: [{ label: "Total Revenue", data: [30, 70, 30, 100, 50, 130, 100, 140], backgroundColor: "transparent", borderColor: "#09ad95", pointBackgroundColor: "#09ad95", pointHoverBackgroundColor: "#09ad95", pointBorderColor: "#09ad95", pointHoverBorderColor: "#09ad95", pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 2, borderWidth: 3 }] }, options: { maintainAspectRatio: !1, legend: { display: !1 }, responsive: !0, tooltips: { mode: "index", titleFontSize: 12, titleFontColor: "#6b6f80", bodyFontColor: "#6b6f80", backgroundColor: "#fff", titleFontFamily: "Montserrat", bodyFontFamily: "Montserrat", cornerRadius: 3, intersect: !1 }, scales: { xAxes: [{ gridLines: { color: "transparent", zeroLineColor: "transparent" }, ticks: { fontSize: 2, fontColor: "transparent" } }], yAxes: [{ display: !1, ticks: { display: !1 } }] }, title: { display: !1 }, elements: { line: { borderWidth: 1 }, point: { radius: 4, hitRadius: 10, hoverRadius: 4 } } } }), t = document.getElementById("areaChart4").getContext("2d"), new Chart(t, { type: "line", data: { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], type: "line", datasets: [{ label: "Total Profit", data: [24, 18, 28, 21, 32, 28, 30], backgroundColor: "transparent", borderColor: "#f7b731", pointBackgroundColor: "#f7b731", pointHoverBackgroundColor: "#f7b731", pointBorderColor: "#f7b731", pointHoverBorderColor: "#f7b731", pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 2, borderWidth: 3 }] }, options: { maintainAspectRatio: !1, legend: { display: !1 }, responsive: !0, tooltips: { mode: "index", titleFontSize: 12, titleFontColor: "#6b6f80", bodyFontColor: "#6b6f80", backgroundColor: "#fff", titleFontFamily: "Montserrat", bodyFontFamily: "Montserrat", cornerRadius: 3, intersect: !1 }, scales: { xAxes: [{ gridLines: { color: "transparent", zeroLineColor: "transparent" }, ticks: { fontSize: 2, fontColor: "transparent" } }], yAxes: [{ display: !1, ticks: { display: !1 } }] }, title: { display: !1 }, elements: { line: { borderWidth: 1 }, point: { radius: 4, hitRadius: 10, hoverRadius: 4 } } } }),
    echarts.init(document.getElementById("index"), { color: ["#0774f8", "#d43f8d"], categoryAxis: { axisLine: { lineStyle: { color: "#77778e" } }, splitLine: { lineStyle: { color: ["rgba(119, 119, 142, 0.2)"] } } }, grid: { x: 40, y: 20, x2: 40, y2: 20 }, valueAxis: { axisLine: { lineStyle: { color: "#77778e" } }, splitArea: { show: !1, areaStyle: { color: ["rgba(255,255,255,0.1)"] } }, splitLine: { lineStyle: { color: ["rgba(119, 119, 142, 0.2)"] } } } }).setOption({ tooltip: { trigger: "axis" }, legend: { data: ["Revenue", "Expenses"] }, toolbox: { show: !1 }, calculable: !1, xAxis: [{ type: "category", data: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"] }], yAxis: [{ type: "value" }], series: [{ name: "", type: "bar", data: [30, 42.3, 60.2, 70.3, 60.8, 19.8, 27.8, 85.63, 52.63, 14.25, 63.25, 12.32], markPoint: { data: [{ type: "max", name: "" }, { type: "min", name: "" }] }, markLine: { data: [{ type: "average", name: "" }] } }, { name: " Expenses", type: "bar", data: [16.6, 40.9, 50, 16.4, 28.7, 80.7, 178.6, 188.2, 48.7, 18.8, 6, 2.3], markPoint: { data: [{ name: "Purchased Price", value: 182.2, xAxis: 7, yAxis: 183 }, { name: "Purchased Price", value: 2.3, xAxis: 11, yAxis: 3 }] }, markLine: { data: [{ type: "average", name: "" }] } }] }),
        new Morris.Donut({ element: "morrisBar8", data: [{ value: 50, label: "Technology" }, { value: 25, label: "Furniture" }, { value: 15, label: "Office Suppliers" }], backgroundColor: "rgba(119, 119, 142, 0.2)", labelColor: "#77778e", colors: ["#0774f8", "#d43f8d", "#09ad95"], formatter: function(e) { return e + "%" } }).on("click", (function(e, t) { console.log(e, t) }))
}));
