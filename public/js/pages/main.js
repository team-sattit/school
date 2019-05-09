var _componentUniform = function() {
             if (!$().uniform) {
                 console.warn('Warning - uniform.min.js is not loaded.');
                 return;
             }

             // Initialize
             $('.form-input-styled').uniform();
         };
var _componentDatePicker = function() { 
    var locatDate = moment.utc().format('YYYY-MM-DD');
        var stillUtc = moment.utc(locatDate).toDate();
        var year = parseInt(moment(stillUtc).local().format('YYYY')) + 2;
        $('.date').attr('readonly', true);
        // console.log(local);
        $('.date').daterangepicker({
            "applyClass": 'bg-slate-600',
            "cancelClass": 'btn-light',
            "singleDatePicker": true,
            "locale": {
                "format": 'YYYY-MM-DD'
            },
            "showDropdowns": true,
            "minYear": 1900,
            "maxYear": year,
            "timePicker": false,
            "alwaysShowCalendars": true,
        });
};
    var _componentSelect2 = function() {
         if (!$().select2) {
             console.warn('Warning - select2.min.js is not loaded.');
             return;
         }

         if ($('#modal_remote')) {
             $('.select').select2({
                 dropdownAutoWidth: true,
                 dropdownParent: $("#modal_remote"),
             });
         } else {
             $('.select').select2({
                 dropdownAutoWidth: true,
             });
         }
         // Initialize
         $('.dataTables_length select').select2({
             minimumResultsForSearch: Infinity,
             dropdownAutoWidth: true,
             width: 'auto'
         });
     };
    var _componentSelect2Normal = function() {
         if (!$().select2) {
             console.warn('Warning - select2.min.js is not loaded.');
             return;
         }
         $('.select').select2({
             dropdownAutoWidth: true,
         });
      
     };
     var _componentSwitchery = function() {
         if (typeof Switchery == 'undefined') {
             console.warn('Warning - switchery.min.js is not loaded.');
             return;
         }

         // Initialize
         var elems = Array.prototype.slice.call(document.querySelectorAll('.form-control-switchery'));
         elems.forEach(function(html) {
             var switchery = new Switchery(html);
         });
     };
    var _componentValidation = function() {
        $('#content_form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
        $('#content_form').on('submit', function(e) {
            e.preventDefault();
            //if ($('#invoice-form').parsley().isValid()) {
                    $('#submit').hide();
                    $('#submiting').show();
                    $(".ajax_error").remove();
                    var submit_url = $('#content_form').attr('action');
                    //Start Ajax
                    var formData = new FormData($("#content_form")[0]);
                    $.ajax({
                        url: submit_url,
                        type: 'POST',
                        data: formData,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        dataType: 'JSON',
                        success: function(data) {
                                new PNotify({
                                    title: jsUcfirst(data.status),
                                    text: data.message,
                                    type: data.status,
                                });
                                $('#submit').show();
                                $('#submiting').hide();
                                $('#modal_remote').modal('toggle');
                                if (typeof(tariq) != "undefined" && tariq !== null) {
                                    tariq.ajax.reload();
                                }
                                if (data.goto) {
                                    swal({
                                        title: "Your Data Saved Success full",
                                        text: "Would you like to Reload this Page?",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            window.location.href = data.goto;
                                        }
                                    });
                                }
                        },
                        error: function(data) {
                            var jsonValue = $.parseJSON(data.responseText);
                            const errors = jsonValue.errors;
                                var i = 0;
                                $.each(errors, function(key, value) {
                                    const first_item = Object.keys(errors)[i]
                                    const message = errors[first_item][0]
                                    $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                                    new PNotify({
                                        title: 'Error',
                                        text: value,
                                        type: 'danger',
                                    });
                                    i++;
                                });
                                _componentSelect2Normal();
                                $('#submit').show();
                                $('#submiting').hide();
                        }
                    });
           // }
        });
    };
     $(document).ready(function() {
         $(document).on('click', '#delete_item', function(e) {
             e.preventDefault();
             var row = $(this).data('id');
             var url = $(this).data('url');
             $('#action_menu_' + row).hide();
             $('#delete_loading_' + row).show();
             //console.log(row, url);
             swal({
                     title: "Are you sure?",
                     text: "Once deleted, it will deleted all related Data!",
                     icon: "warning",
                     buttons: true,
                     dangerMode: true,
                 })
                 .then((willDelete) => {
                     if (willDelete) {
                         //console.log(row, url);
                         $.ajax({
                             url: url,
                             method: 'Delete',
                             contentType: false, // The content type used when sending data to the server.
                             cache: false, // To unable request pages to be cached
                             processData: false,
                             dataType: 'JSON',
                             success: function(data) {
                                 new PNotify({
                                     title: jsUcfirst(data.status),
                                     text: data.message,
                                     type: data.status,
                                 });
                                 if (tariq) {
                                     tariq.ajax.reload();
                                 }
                             },
                             error: function(data) {
                                 var jsonValue = $.parseJSON(data.responseText);
                                 const errors = jsonValue.errors
                                 var i = 0;
                                 $.each(errors, function(key, value) {
                                     new PNotify({
                                         title: 'Error',
                                         text: value,
                                         type: 'danger',
                                     });
                                     i++;
                                 });
                                 $('#delete_loading_' + row).hide();
                                 $('#action_menu_' + row).show();
                             }
                         });
                     } else {
                         $('#delete_loading_' + row).hide();
                         $('#action_menu_' + row).show();
                     }
                 });
         });

         $(document).on('click', '#change_status', function(e) {
             e.preventDefault();
             var row = $(this).data('id');
             var url = $(this).data('url');
             var status = $(this).data('status');
             if (status == 1) {
                 msg = 'Change Status Form Online To Offline';
             } else {
                 msg = 'Change Status Form Offline To Online';
             }
             $('#action_menu_' + row).hide();
             $('#delete_loading_' + row).show();
             //console.log(row, url);
             swal({
                     title: "Are you sure?",
                     text: msg,
                     icon: "warning",
                     buttons: true,
                     dangerMode: true,
                 })
                 .then((willDelete) => {
                     if (willDelete) {
                         $.ajax({
                             url: url,
                             method: 'Put',
                             contentType: false, // The content type used when sending data to the server.
                             cache: false, // To unable request pages to be cached
                             processData: false,
                             dataType: 'JSON',
                             success: function(data) {
                                 new PNotify({
                                     title: jsUcfirst(data.status),
                                     text: data.message,
                                     type: data.status,
                                 });
                                 if (tariq) {
                                     tariq.ajax.reload();
                                 }
                             },
                             error: function(data) {
                                 var jsonValue = $.parseJSON(data.responseText);
                                 const errors = jsonValue.errors
                                 var i = 0;
                                 $.each(errors, function(key, value) {
                                     new PNotify({
                                         title: 'Error',
                                         text: value,
                                         type: 'danger',
                                     });
                                     i++;
                                 });
                                 $('#delete_loading_' + row).hide();
                                 $('#action_menu_' + row).show();
                             }
                         });
                     } else {
                         $('#delete_loading_' + row).hide();
                         $('#action_menu_' + row).show();
                     }
                });
         });

         $(document).on('click', '#content_managment', function(e) {
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
                     $('.modal-body').html(data); // load response
                     $('#modal-loader').hide();
                     _componentSelect2();
                     _componentSwitchery();
                     _componentUniform();
                     _componentValidation();
                 })
                 .fail(function(data) {
                     console.log(data);
                     $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                     $('#modal-loader').hide();
                 });
         });
          //console.log(estimate_time)
        var locatDate = moment.utc().format('YYYY-MM-DD');
        var stillUtc = moment.utc(locatDate).toDate();
        var year = parseInt(moment(stillUtc).local().format('YYYY')) + 2;
        $('.date').attr('readonly', true);
        // console.log(local);
        $('.date').daterangepicker({
            "applyClass": 'bg-slate-600',
            "cancelClass": 'btn-light',
            "singleDatePicker": true,
            "locale": {
                "format": 'YYYY-MM-DD'
            },
            "showDropdowns": true,
            "minYear": 1900,
            "maxYear": year,
            "timePicker": false,
            "alwaysShowCalendars": true,
        });
    });

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
// var unsaved = false;
// $(":input").change(function(){ //triggers change in all input fields including text type
//     unsaved = true;
// });
// function unloadPage(){ 
//     if(unsaved){
//         return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
//     }
// }
// window.onbeforeunload = unloadPage;