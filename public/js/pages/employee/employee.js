var tariq = '';

var DatatableButtonsHtml5 = function() {

    // Basic Datatable examples
    var _componentDatatableButtonsHtml5 = function() {
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
        tariq = $('.content_managment_table').DataTable({
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5', {
                        text: 'Reload',
                        action: function(e, dt, node, config) {
                            dt.ajax.reload();
                        }
                    },
                ]
            },
            processing: true,
            serverSide: true,
            ajax: $('.content_managment_table').data('url'),
            columns: [{
                data: 'code',
                name: 'code'
            },{
                data: 'name',
                name: 'name'
            }, {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            }, {
                data: 'date_of_birth',
                name: 'date_of_birth'
            }, {
                data: 'mobile_no',
                name: 'mobile_no'
            }, {
                data: 'department',
                name: 'department'
            }, {
                data: 'designation',
                name: 'designation'
            }, {
                data: 'joining_date',
                name: 'joining_date'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });
    };

    return {
        init: function() {
            _componentDatatableButtonsHtml5();
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableButtonsHtml5.init();
});

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
