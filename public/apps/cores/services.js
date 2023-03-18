app.factory('$apply', ['$rootScope', function ($rootScope) {
    return function (fn) {
        setTimeout(function () {
            $rootScope.$apply(fn);
        });
    };
}]);
app.factory('formatDateTime', function () {
    return function (date, format) {
        if (date) {
            format = format || 'DD/MM/YYYY';
            return moment(date).format(format);
        } else
            return "";
    };
});

//-------- ng-enter ---------//
app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

app.directive('iCheck', ['$timeout', '$parse', function ($timeout, $parse) {
    return {
        compile: function (element, $attrs) {
            var icheckOptions = {
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_flat-green'
            };

            var modelAccessor = $parse($attrs['ngModel']);
            return function ($scope, element, $attrs, controller) {

                var modelChanged = function (event) {
                    $scope.$apply(function () {
                        if (modelAccessor.length > 0) {
                            modelAccessor.assign($scope, event.target.checked);
                        }
                    });
                };
                $scope.$watch(modelAccessor, function (val) {
                    var action = val ? 'check' : 'uncheck';
                    element.iCheck(icheckOptions, action).on('ifChanged', modelChanged);
                });

            };
        }
    };
}]);


app.directive('datePicker', function () {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                $(element).datepicker({
                    autoclose: true,
                    calendarWeeks: false,
                    clearBtn: false,
                    daysOfWeekDisabled: [],
                    endDate: Infinity,
                    forceParse: true,
                    format: 'dd/mm/yyyy',
                    keyboardNavigation: true,
                    language: 'vi',
                    minViewMode: 0,
                    multidate: false,
                    multidateSeparator: ',',
                    orientation: "auto",
                    rtl: false,
                    startDate: -Infinity,
                    startView: 0,
                    todayBtn: 'linked',
                    todayHighlight: true,
                    weekStart: 0
                });
            });


        }
    };
});


/**
 * Chọn kết quả đánh giá
 * @type type
 */
app.factory('$par_index_factory', function ($apply, $sce) {
    var actions = {
        numberToRoman: function (num) {
            var result = '';
            var decimal = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1];
            var roman = ["M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"];
            for (var i = 0; i <= decimal.length; i++) {
                // looping over every element of our arrays
                while (num % decimal[i] < num) {
                    // keep trying the same number until it won't fit anymore
                    result += roman[i];
                    // add the matching roman number to our result string
                    num -= decimal[i];
                    // remove the decimal value of the roman number from our number
                }
            }
            return result;
        },
        uploadFile: function (data, tagsUpload, tagsProgress, tagsBtnUpload, tagsProcess, fc_callback) {
            var files = document.getElementById(tagsUpload).files;
            if (files.length == 0) {
                bootbox.alert('Chưa chọn tài liệu tải lên');
                return false;
            }

            $('#' + tagsBtnUpload).hide();
            $('#' + tagsProcess).show();
            $('#' + tagsProgress).empty();
            $('#' + tagsUpload).hide();
            HxUploadFiles.serverUpload = SITE_ROOT + 'rest/media/upload';
            HxUploadFiles.tagsUpload = tagsUpload;
            HxUploadFiles.tagsProgress = tagsProgress;
            new Promise((resolve, reject) => {
                HxUploadFiles.doUpload(resolve, reject);
            }).then(function (success) {
                $apply(function () {
                    data = success;
                    setTimeout(function () {
                        $('#' + tagsProcess).hide();
                        $('#' + tagsBtnUpload).show();
                        $('#' + tagsUpload).show();
                    }, 2000);
                    fc_callback();
                });
            }, function error(error) {
                $('#' + tagsBtnUpload).show();
                $('#' + tagsUpload).show();
                $('#' + tagsUpload).show();
            });
        },


        uploadMultiFile: function (tagsUpload, tagsProgress, tagsBoxUpload, tagsProcess, fc_callback) {
            var files = document.getElementById(tagsUpload).files;
            if (files.length == 0) {
                console.log('Chưa chọn tài liệu tải lên', 'error');
                fc_callback([]);
                return false;
            }
            $('#' + tagsBoxUpload).hide();
            $('#' + tagsProcess).show();
            $('#' + tagsProgress).empty();
            $('#' + tagsUpload).hide();
            HxUploadFiles.serverUpload = SITE_ROOT + 'rest/media/upload';
            HxUploadFiles.tagsUpload = tagsUpload;
            HxUploadFiles.tagsProgress = tagsProgress;
            new Promise((resolve, reject) => {
                HxUploadFiles.doUpload(resolve, reject);
            }).then(function (success) {
                $apply(function () {
                    $('#' + tagsBoxUpload).show();
                    setTimeout(function () {
                        $('#' + tagsProcess).hide();
                    }, 4000);
                    fc_callback(success.data);
                });
            }, function error(error) {
                fc_callback(error.data);
                $('#' + tagsBoxUpload).show();
            });
        },

        removeFile: function (data, tagsUpload, tagsBtnUpload) {
            $('#' + tagsBtnUpload).show(); //input
            $('#' + tagsBtnUpload).show(); //btn
            data.filename = null;
            data.filepath = null;
        },

        renderDepthOu: function (depth) {
            if ($.trim(depth) == '') {
                return '';
            }
            var splitDepth = depth.split('/');
            var depstring = '';
            for (var i = 1; i < splitDepth.length; i++) {
                depstring += ' ----';
            }
            return depstring;
        },
        /**
         *
         * @param string anchor Mã ID thẻ chọn
         * @param object data Mảng dữ liệu ban đầu chứa danh sách kết quả dùng để gán kết quả đã chọn
         * @param int val kết quả trọng
         * @param string type Kiểu đối tượng đang chọn : checkbox || radio
         * @returns {undefined}
         */
        chooseChild: function (data, val, type, anchor) {
            data.child_chosen = data.child_chosen ? data.child_chosen : [];
            $apply(function () {
                if (type == 'radio') {
                    data.child_chosen = [val];
                } else {
                    if (data.child_chosen.indexOf(val) != -1) {
                        data.child_chosen.splice(data.child_chosen.indexOf(val), 1);
                    }
                    if ($('#' + anchor).prop('checked')) {
                        data.child_chosen.push(val);
                    }
                }
            });
        },
        /**
         *
         * @param string anchor Mã ID thẻ chọn
         * @param object data Mảng dữ liệu ban đầu chứa danh sách kết quả dùng để gán kết quả đã chọn
         * @param int val kết quả trọng
         * @param string type Kiểu đối tượng đang chọn : checkbox || radio
         * @returns {undefined}
         */
        chooseChildVerify: function (data, val, type) {
            data.child_chosen_verify = data.child_chosen_verify ? data.child_chosen_verify : [];
            $apply(function () {
                if (type == 'radio') {
                    var data_new = [val];
                    if (data.child_chosen_verify.length === data_new.length && data.child_chosen_verify.every(function (value, index) {
                        return value === data_new[index]
                    })) {
                        data.child_chosen_verify = [];
                    } else {
                        data.child_chosen_verify = [val];
                    }

                } else {
                    //Chọn đáp án khác (id = 0)
                    if (val == 0) {
                        if (data.child_chosen_verify.indexOf(val) != -1) {
                            data.child_chosen_verify = [];
                        } else {
                            data.child_chosen_verify = [val];
                        }
                    } else {
                        //Bỏ chọn đáp án khác
                        if (data.child_chosen_verify.indexOf(0) != -1) {
                            data.child_chosen_verify.splice(data.child_chosen_verify.indexOf(0), 1);
                        }
                        if (data.child_chosen_verify.indexOf(val) != -1) {
                            data.child_chosen_verify.splice(data.child_chosen_verify.indexOf(val), 1);
                        } else {
                            data.child_chosen_verify.push(val);
                        }
                    }
                }
            });
        },
        showData: function (data) {
            if (data)
                data = data.replace(/\n/g, '<br>');
            return data ? $sce.trustAsHtml(data) : $sce.trustAsHtml('--');
        }
    };
    return actions;
});

/**
 * Chọn kết quả đánh giá
 * @type type
 */
app.factory('$coresFactory', function ($apply) {
    var actions = {
        httpErrors: function (xhr) {
            var errors = [];
            try {
                if (xhr.status == 401 || xhr.status == 403 || xhr.status == 419) {
                    $.notify(xhr.data.message, 'error');
                    location.href = SITE_ROOT;
                } else if (xhr.status == 500) {
                    $.notify('Yêu cầu thất bại, bạn vui lòng tải lại trang sau đó thao tác lại.', 'error');
                } else {
                    if (typeof xhr.data.errors != 'undefined') {
                        errors = xhr.data.errors;
                    }
                    $.notify(xhr.data.message, 'error');
                }
            } catch (exception) {
                $.notify('Yêu cầu thất bại, bạn vui lòng tải lại trang sau đó thao tác lại.', 'error');
                errors = [];
            }
            return errors;

            var errors = [];
            try {
                if (xhr.status == 422) {
                    if (typeof xhr.data.errors != 'undefined') {
                        errors = xhr.data.errors;
                    } else {
                        $.notify(xhr.data.messsage, 'error');
                    }

                } else if (xhr.status == 403) {
                    $.notify(xhr.data.message, 'error');
                } else {
                    errors = [];
                    $.notify('Yêu cầu thất bại, bạn vui lòng tải lại trang sau đó thao tác lại.', 'error');
                }
            } catch (exception) {
                $.notify('Yêu cầu thất bại, bạn vui lòng tải lại trang sau đó thao tác lại.', 'error');
                errors = [];
            }
            return errors;
        },
        numberToRoman: function (num) {
            var result = '';
            var decimal = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1];
            var roman = ["M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"];
            for (var i = 0; i <= decimal.length; i++) {
                // looping over every element of our arrays
                while (num % decimal[i] < num) {
                    // keep trying the same number until it won't fit anymore
                    result += roman[i];
                    // add the matching roman number to our result string
                    num -= decimal[i];
                    // remove the decimal value of the roman number from our number
                }
            }
            return result;
        },
        uploadFile: function (data, tagsUpload, tagsProgress, tagsBtnUpload, tagsProcess, fc_callback) {
            var files = document.getElementById(tagsUpload).files;
            if (files.length == 0) {
                bootbox.alert('Chưa chọn tài liệu tải lên');
                return false;
            }

            $('#' + tagsBtnUpload).hide();
            $('#' + tagsProcess).show();
            $('#' + tagsProgress).empty();
            $('#' + tagsUpload).hide();
            HxUploadFiles.serverUpload = SITE_ROOT + 'rest/media/upload';
            HxUploadFiles.tagsUpload = tagsUpload;
            HxUploadFiles.tagsProgress = tagsProgress;
            new Promise((resolve, reject) => {
                HxUploadFiles.doUpload(resolve, reject);
            }).then(function (success) {
                $apply(function () {
                    data = success;
                    setTimeout(function () {
                        $('#' + tagsProcess).hide();
                        $('#' + tagsBtnUpload).show();
                        $('#' + tagsUpload).show();
                    }, 2000);
                    fc_callback();
                });
            }, function error(error) {
                $('#' + tagsBtnUpload).show();
                $('#' + tagsUpload).show();
                $('#' + tagsUpload).show();
            });
        },
        loadFileExcel: function (tagsUpload, typeUpload, fc_callback, fc_callback_error) {
            var files = document.getElementById(tagsUpload).files;
            if (files.length == 0) {
                console.log('Chưa chọn tài liệu tải lên', 'error');
                fc_callback([]);
                return false;
            }
            HxLoadFileExcel.serverUpload = SITE_ROOT + '/rest/excel/loadContent';
            HxLoadFileExcel.tagsUpload = tagsUpload;
            HxLoadFileExcel.typeUpload = typeUpload;
            new Promise((resolve, reject) => {
                HxLoadFileExcel.doUpload(resolve, reject);
            }).then(function (success) {
                $apply(function () {
                    fc_callback(success);
                });
            }, function error(error) {
                console.log(error);
                fc_callback_error(error);
            });
        },

        removeFile: function (data, tagsUpload, tagsBtnUpload) {
            $('#' + tagsBtnUpload).show(); //input
            $('#' + tagsUpload).show(); //input
            $('#' + tagsBtnUpload).show(); //btn
            data.filename = null;
            data.filepath = null;
        },

        renderDepthOu: function (depth) {
            if ($.trim(depth) == '') {
                return '';
            }
            var splitDepth = depth.split('/');
            var depstring = '';
            for (var i = 1; i < splitDepth.length; i++) {
                depstring += ' ----';
            }
            return depstring;
        },

        render_canledar: function (events, tagRender, eventClick) {
            $(function () {
                $(tagRender).fullCalendar('destroy');
                $(tagRender).fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        buttonText: {
                            today: 'today',
                            month: 'month',
                            week: 'week',
                            day: 'day'
                        },
                        events: function (start, end, tz, callback) {
                            callback(events);
                        },
                        eventClick: eventClick,
                        dayNamesShort: [
                            'Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4',
                            'Thứ 5', 'Thứ 6', 'Thứ 7'
                        ],
                        monthNames: [
                            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
                            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                        ],
                        buttonText: {
                            today: 'Ngày hiện tại',
                            month: 'Tháng',
                            week: 'Tuần',
                            day: ' Ngày'
                        },
                        monthNamesShort: [
                            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
                            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                        ],
                        dayNames: [
                            'Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4',
                            'Thứ 5', 'Thứ 6', 'Thứ 7'
                        ]
                    }
                );

            });

        },
        checkRole: function (role, allRole) {
            if (typeof (role) == 'object') {
                var hasPermit = false;
                for (var i = 0; i < role.length; i++) {
                    if (allRole.indexOf(role[i]) != -1) {
                        hasPermit = true;
                    }
                }
                return hasPermit;
            } else {
                return allRole.indexOf(role) != -1 ? true : false;
            }
        },
    }
    return actions;
});
app.directive('selectSearch', function () {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                setTimeout(function () {
                    let pla = $(element).data("placeholder") || '';
                    $(element).select2({
                        placeholder: pla
                    });
                });
            });
        }
    };
});
app.directive('selectSearchModal', function () {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                setTimeout(function () {
                    let pla = $(element).data("placeholder") || '';
                    let modal = $(element).data("modal") || '';
                    if (modal) {
                        console.log(modal);
                        $(element).select2({
                            placeholder: pla,
                            dropdownParent: $('#' + modal)
                        });
                    } else {
                        console.log(1);
                        $(element).select2({
                            placeholder: pla,
                        });
                    }
                });
            });
        }
    };
});
app.directive('addCommas', function () {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                var nStr = $(element).val();
                nStr += '';
                if (nStr != '') {
                    nStr = nStr.replace(/,/g, '');
                }
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                $(element).val(x1 + x2);
            });
        }
    };
});
app.directive('myLfmImg', function ($apply) {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            $apply(function () {
                $(element).filemanager('Images', {prefix: route_prefix});

            });
        }
    };
});


app.directive('myLfmFile', function ($apply) {
    return {
        restrict: 'C',
        link: function (scope, element, attrs) {
            $apply(function () {
                $(element).filemanager('Files', {prefix: route_prefix});
            });
        }
    };
});

app.directive('fileChange', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        scope: {
            fileChange: '&'
        },
        link: function link(scope, element, attrs, ctrl) {
            element.on('change', onChange);
            scope.$on('destroy', function () {
                element.off('change', onChange);
            });

            function onChange() {
                ctrl.$setViewValue(element[0].files[0]);
                scope.fileChange();
            }
        }
    };
});

app.filter('unsafe', function ($sce) {
    return $sce.trustAsHtml;
});
app.directive('convertToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(val) {
                return val != null ? parseInt(val, 10) : null;
            });
            ngModel.$formatters.push(function(val) {
                return val != null ? '' + val : null;
            });
        }
    };
});
app.directive('stringToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(value) {
                return '' + value;
            });
            ngModel.$formatters.push(function(value) {
                return parseFloat(value);
            });
        }
    };
});