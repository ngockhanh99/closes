'use strict'
start()

function start(){
    getQuantityProcedure()
    getImportProduct()
}

function getQuantityProcedure() {
    fetch(SITE_ROOT + 'mca/report/report1/getProductGroupSpec')
        .then(res => res.json())
        .then(data => {
            let listQuantityProcedure = data
            loadChart.loadStackedColumnChart(listQuantityProcedure)
            loadChart.loadPolarAreaCharts(listQuantityProcedure)
        })
}

function getImportProduct(){
    fetch(SITE_ROOT + 'mca/report/report1/getImportGroupSpec')
        .then(res => res.json())
        .then(data => {
            let listImportProduct = data
            loadChart.loadStackedColumnChart2(listImportProduct)
            loadChart.loadPolarAreaCharts2(listImportProduct)
        })
}

const loadChart = {
    loadStackedColumnChart: function (listQuantityProcedure) {
        var quantity_unprocessed = [];
        var quantity_processed = [];
        var categories = [];
        for (var i in listQuantityProcedure){
            let item = listQuantityProcedure[i];
            quantity_unprocessed.push(item.total_quantity_unprocessed);
            quantity_processed.push(item.total_quantity_processed);
            categories.push(item.name);
        }
        var options = {
                chart: {
                    height: 360,
                    type: "bar",
                    stacked: !0,
                    zoom: {
                        enabled: !0
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 300,
                        }
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        borderRadius: 5
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 300,
                        }
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "Chưa sở chế",
                    data: quantity_unprocessed
                }, {
                    name: "Đã sơ chế",
                    data: quantity_processed
                }],
                yaxis: [{
                    title: {
                        text: '' +
                        "Kg"
                    },
                    labels: {
                        formatter: function (value) {
                          return value.toLocaleString('en-US')+" Kg";
                        }
                      },
                }],
                title: {
                    text: 'Biểu đồ sản lượng sản xuất',
                    align: 'center',
                    style: {
                        fontWeight: 'bold',
                        fontSize: 15
                    }
                },
                xaxis: {
                    categories: categories
                },
                colors: ["#556ee6", "#34c38f"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                }
            },
            chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
        chart.render();

    },
    loadPolarAreaCharts: function (listQuantityProcedure) {
        var quantity = [];
        var categories = [];
        for (var i in listQuantityProcedure){
            let item = listQuantityProcedure[i];
           
            quantity.push(item.total_quantity);
            categories.push(item.name);
        }

        var options = {
            series: quantity,
            chart: {
                height: 360,
                type: 'donut',
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            title: {
                text: 'Biểu đồ sản lượng sản xuất',
                align: 'center',
                style: {
                    fontWeight: 'bold',
                    fontSize: 15,
                },
            },
            yaxis: [{
                title: {
                    text: '' +
                    "Kg"
                },
                labels: {
                    formatter: function (value) {
                      return value.toLocaleString('en-US')+" Kg";
                    }
                  },
            }],
            legend: {
                position: "bottom",
                // offsetX: 10,
                // offsetY: 40,
            },
            colors: ['#008FFB', "#f1b44c", '#CED4DC', "#00B8FBFF", '#00FB15FF', '#8A00FBFF', '#5400FBFF'],
            labels: categories,
        };

        var chart = new ApexCharts(document.querySelector("#polar-area-charts"), options);
        chart.render();
    },
    loadStackedColumnChart2: function (listImportProduct) {
        var total_number_missing = [];
        var total_quantity_needed = [];
        var categories = [];
        for (var i in listImportProduct){
            let item = listImportProduct[i];

            
            total_number_missing.push(item.total_number_missing);
            total_quantity_needed.push(item.total_quantity_needed);
            categories.push(item.name);
        }
        var options = {
                chart: {
                    height: 360,
                    type: "bar",
                    stacked: !0,
                    zoom: {
                        enabled: !0
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 300,
                        }
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        borderRadius: 5
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 300,
                        }
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "Chưa nhập",
                    data: total_number_missing
                }, {
                    name: "Đã nhập",
                    data: total_quantity_needed
                }],
                yaxis: [{
                    title: {
                        text: '' +
                        "Kg"
                    },
                    labels: {
                        formatter: function (value) {
                          return value.toLocaleString('en-US')+" Kg";
                        }
                      },
                }],
                title: {
                    text: 'Biểu đồ nhu cầu sản phẩm',
                    align: 'center',
                    style: {
                        fontWeight: 'bold',
                        fontSize: 15
                    }
                },
                xaxis: {
                    categories: categories
                },
                colors: ["#556ee6", "#34c38f"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                }
            },
            chart = new ApexCharts(document.querySelector("#stacked-column-chart-2"), options);
        chart.render();

    },
    loadPolarAreaCharts2: function (listImportProduct) {
        var quantity = [];
        var categories = [];
        for (var i in listImportProduct){
            let item = listImportProduct[i];
            quantity.push(item.total_amount);
            categories.push(item.name);
        }

        var options = {
            series: quantity,
            chart: {
                height: 360,
                type: 'donut',
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            title: {
                text: 'Biểu đồ nhu cầu sản phẩm',
                align: 'center',
                style: {
                    fontWeight: 'bold',
                    fontSize: 15,
                },
            },
            yaxis: [{
                title: {
                    text: '' +
                    "Kg"
                },
                labels: {
                    formatter: function (value) {
                      return value.toLocaleString('en-US')+" Kg";
                    }
                  },
            }],
            legend: {
                position: "bottom",
                // offsetX: 10,
                // offsetY: 40,
            },
            colors: ['#008FFB', "#f1b44c", '#CED4DC', "#00B8FBFF", '#00FB15FF', '#8A00FBFF', '#5400FBFF'],
            labels: categories,
        };

        var chart = new ApexCharts(document.querySelector("#polar-area-charts-2"), options);
        chart.render();
    },
}
