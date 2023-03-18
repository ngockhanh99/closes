angular.module('myApp').controller('reportCtrl', function ($scope, $http, $apply, $location) {
    $scope.data = {
        reportData: {},
        reportImportProduct: {},
    };
    $scope.actions = {
        init() {
            $scope.actions.getReport();
            $scope.actions.getReportImportProduct();
        },
        getReport: function () {
            $http.get(SITE_ROOT + 'mca/report/report1/getProductGroupSpec')
                .then(function (resp) {
                    $scope.data.reportData = resp.data;
                    $scope.actions.loadStackedColumnChart();
                    $scope.actions.loadPolarAreaCharts();
                });
        },
        getReportImportProduct: function () {
            $http.get(SITE_ROOT + 'mca/report/report1/getImportGroupSpec')
                .then(function (resp) {
                    $scope.data.reportImportProduct = resp.data;
                    $scope.actions.loadStackedColumnChart2();
                    $scope.actions.loadPolarAreaCharts2();
                });
        },
        loadStackedColumnChart: function () {
            var quantity_unprocessed = [];
            var quantity_processed = [];
            var categories = [];
            for (var i in $scope.data.reportData){
                let item = $scope.data.reportData[i];
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
                            text: 'Kg'
                        }
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

        loadPolarAreaCharts: function () {
            var quantity = [];
            var categories = [];
            for (var i in $scope.data.reportData){
                let item = $scope.data.reportData[i];
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
                    text: 'Biểu đồ sản lương sản xuất',
                    align: 'center',
                    style: {
                        fontWeight: 'bold',
                        fontSize: 15,
                    },
                },
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
        loadStackedColumnChart2: function () {
            var total_number_missing = [];
            var total_quantity_needed = [];
            var categories = [];
            for (var i in $scope.data.reportImportProduct){
                let item = $scope.data.reportImportProduct[i];
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
                            text: 'KG'
                        }
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

        loadPolarAreaCharts2: function () {
            var quantity = [];
            var categories = [];
            for (var i in $scope.data.reportImportProduct){
                let item = $scope.data.reportImportProduct[i];
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
    };
    $scope.actions.init();
});
