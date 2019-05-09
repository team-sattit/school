var tariq = '';
var DatatableButtonsHtml5 = function() {
    var _componentDatatableButtonsHtml5 = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }
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
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'contact',
                name: 'contact'
            },{
                data: 'info',
                name: 'info'
            },{
                data: 'description',
                name: 'description'
            },{
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
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
$(document).ready(function(){
    $(document).on('click', '#update_logo', function(){
        $('#upload_logo_field').toggle();
        $('#delete_logo').prop('checked',false);
        $('input[name="logo"]').attr('required',true);
        $.uniform.update();
        //console.log($('#upload_image_field').attr('style'));
    });
    $(document).on('click', '#delete_logo', function(){
        var display = $('#upload_logo_field').attr('style');
        if (display == '') {
            $('#upload_logo_field').attr('style', 'display: none');
        }
        $('#update_logo').prop('checked',false);
        $('input[name="logo"]').attr('required',false);
        $.uniform.update();
    })
    $(document).on('click', '#update_fav', function(){
        $('#upload_fav_field').toggle();
        $('#delete_fav').prop('checked',false);
        $('input[name="favicon"]').attr('required',true);
        $.uniform.update();
        //console.log($('#upload_image_field').attr('style'));
    });
    $(document).on('click', '#delete_fav', function(){
        var display = $('#upload_fav_field').attr('style');
        if (display == '') {
            $('#upload_fav_field').attr('style', 'display: none');
        }
        $('#update_fav').prop('checked',false);
        $('input[name="favicon"]').attr('required',false);
        $.uniform.update();
    })
});
