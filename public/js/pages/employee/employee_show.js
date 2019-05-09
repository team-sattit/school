var EmployeeForm = function() {
    var _componentDatatable = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fBl><"datatable-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

        // Basic initialization
        $('.content_managment_table').DataTable();
    };

    var _componentOnChangeMaritalStatus = function() {
        $(document).on('change', '#marital_status', function() {
            var marital_status = $(this).val();
            console.log(marital_status);
            if (marital_status == 'married') {
                $('#spouse_name').attr({
                    required: true,
                    readonly: false
                });
                $('#anniversary_date').attr({
                    required: true
                });
                $('#married_row').show();
            } else {
                $('#spouse_name').attr({
                    required: false,
                    readonly: true
                }).val('');
                $('#anniversary_date').attr({
                    required: false
                }).val('');
                $('#married_row').hide();
            }
        });
    }

    var _componentEnableLogin = function() {
        $(document).on('change', '#login_enable', function() {
            if (this.checked) {
                $('#login_row').show();
                $('#email').attr({
                    'readonly': false,
                    'required': true
                });
                $('#username').attr({
                    'readonly': false,
                    'required': true
                });
                $('#password').attr({
                    'readonly': false,
                    'required': true
                });
                $('#password_confirmation').attr({
                    'readonly': false,
                    'required': true
                });
               
            } else {
                $('#login_row').hide();
                $('#email').attr({
                    'readonly': true,
                    'required': false
                }).val('');
                $('#username').attr({
                    'readonly': true,
                    'required': false
                }).val('');
                $('#password').attr({
                    'readonly': true,
                    'required': false
                }).val('');
                $('#password_confirmation').attr({
                    'readonly': true,
                    'required': false
                }).val('');
                $('#role').val('');
            }
        });
    };
    var _componentAjaxModalField = function() {
         $(document).on('click', '#content_show', function(e) {
             e.preventDefault();
             var url = $(this).data('url'); // it will get action url
             $('.modal-body').html(''); // leave it blank before ajax call
             $('#modal-loader').show(); // load ajax loader
             $.ajax({
                     url: url,
                     type: 'Get',
                     dataType: 'html'
                 })
                 .done(function(data) {
                     $('.modal-body').html('');
                     $('.modal-body').html(data); // load response
                     $('#modal-loader').hide();
                     _componentSelect2();
                     _componentValidation();
                     _componentSameAsPresent();
                     _componentDatePicker();
                 })
                 .fail(function(data) {
                     console.log(data);
                     $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                     $('#modal-loader').hide();
                 });
         });
    };
    var _componentSameAsPresent = function() {
        $(document).on('change', '#same_as_present', function() {
            if (this.checked) {
                $('#permanent_house').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_house').val());
                $('#permanent_road').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_road').val());
                $('#permanent_village').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_village').val());
                $('#permanent_post').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_post').val());
                $('#permanent_upozila').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_upozila').val());
                $('#permanent_district').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_district').val());
                $('#permanent_postcode').attr({
                    'readonly': true,
                    'required': false
                }).val($('#present_postcode').val());
            } else {
                $('#permanent_house').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_road').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_village').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_post').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_upozila').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_district').attr({
                    'readonly': false,
                    'required': true
                }).val('');
                $('#permanent_postcode').attr({
                    'readonly': false,
                    'required': true
                }).val('');
            }
        });
        $(document).on('keyup', '#present_house, #present_road, #present_village, #present_post, #present_upozila, #present_district, #present_postcode', function() {
            if ($('#same_as_present').prop("checked")) {
                var present_val = $(this).val();
                var present_id = $(this).attr('id');
                var action = present_id.split('_')[1];
                var premanent_id = 'permanent_' + action;
                $('#' + premanent_id).val(present_val);
            }
        })
    };

    var _componentAjaxField = function() {
        $(document).on('click', '#add_field', function() {
            var field = $(this).data('field');

            var row = parseInt($('#'+field+'_row').val());
            var total_row = parseInt($('#'+field+'_total_row').val());
            var submit_url = $(this).data('url');
            var lang = $(this).data('lang');

            $('.ajaxerror').remove();
            $('#'+field+'_ajaxloader').show();
            $.ajax({
                url: submit_url + '/?row=' + row + '&lang=' + lang,
                type: 'get',
                dataType: 'HTML',
                success: function(data) {
                    $('#'+field).append(data);
                    _componentSelect2Normal();
                    $('#'+field+'_row').val(row + 1);
                    $('#'+field+'_total_row').val(total_row + 1)
                    $('#'+field+'_ajaxloader').hide();
                },
                error: function(data) {
                    $('#'+field).append('<span class="text-danger text-center ajaxerror"> Something Went Wrong. Please Try again later.......</span>');
                    $('#'+field+'_ajaxloader').hide();
                }
            });
        });
        $(document).on('click', '#remove_field', function() {
           swal({
                    title: "Are you sure?",
                    text: "About Delete",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var row = $(this).data('id');
                        var remove_row_id = $(this).data('row');
                        var field_id = $(this).data('field');
                        console.log(field_id)
                        $('#'+remove_row_id+'_id_' + row).remove();
                        var total_row = parseInt($('#'+field_id+'_total_row').val());
                        $('#'+field_id+'_total_row').val(total_row - 1);
                    }
                });
        });
    }


    return {
        init: function() {
            _componentDatatable();
            _componentSelect2Normal();
            _componentOnChangeMaritalStatus();
            _componentSameAsPresent();
            _componentAjaxField();
            _componentEnableLogin();
            _componentAjaxModalField();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EmployeeForm.init();
});

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$(document).ready(function() {
    $(document).on('keyup', '#basic_salary, #medical_allowance, #transport_allowance, #house_rent, #insurance, #commission, #extra', function() {
        calculateTotalSalary();
    })
})

function isStringNullOrWhiteSpace(str) {
    return str === undefined || str === null ||
        typeof str !== 'string' ||
        str.match(/^ *$/) !== null;
}

function check_NaN(num) {
    num = parseFloat(num)
    if (isNaN(num)) {
        num = 0;
    } else {
        if (isStringNullOrWhiteSpace(num)) {
            result = 0;
        } else {
            result = num;
        }
    }
    return num;
}

function calculateTotalSalary() {
    var basic_salary = check_NaN($('#basic_salary').val());
    var house_rent = check_NaN($('#house_rent').val());
    var medical_allowance = check_NaN($('#medical_allowance').val());
    var transport_allowance = check_NaN($('#transport_allowance').val());
    var insurance = check_NaN($('#insurance').val());
    var commission = check_NaN($('#commission').val());
    var extra = check_NaN($('#extra').val());

    var total = basic_salary + house_rent + medical_allowance + transport_allowance + insurance + commission + extra;
    $('#total_slary_val').html(number_format(total));
}

function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}
var number_format = function(number, decimals = 2, dec_point = '.', thousands_sep = ',') {
    number = number.toFixed(decimals);

    var nstr = number.toString();
    nstr += '';
    x = nstr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? dec_point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

    return x1 + x2;
}