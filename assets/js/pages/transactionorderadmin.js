var daterange = $("#defaultdaterange").val();
var res = daterange.split(" - ");
var eDate = res[1].split("/");
var eDateArray = eDate[2]+'-'+eDate[0]+'-'+eDate[1];
var eDateFormat = new Date(eDateArray);
var endDate = moment(eDateFormat).startOf('day');
var sDate = res[0].split("/");
var sDateArray = sDate[2]+'-'+sDate[0]+'-'+sDate[1];
var sDateFormat = new Date(sDateArray);
var startDate = moment(sDateFormat).startOf('day');



	
	
	
	
	$(function () {
    //Exportable table
    var table2 = $('#empTable').DataTable({
		

        'processing': true,
        'serverSide': true,
        "pageLength": 5,
        'serverMethod': 'post',
        'ajax': {
            'url':'ajaxfile.php',
            'type' : 'POST'
        },
        
        'columns': [
        { data: 'layout' },
        { data: 'merchantorderid' },
        { data: 'orderamount' },
        { data: 'modifyorderamount' },
        { data: 'bankaccount' },
        { data: 'orderstatus' },
        { data: 'createddatetime' },
        { data: 'updateddatetime' },
        ],

		dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {
                extend: 'excel',
                //title: 'Excel',
                 action: newexportaction,
                
                exportOptions: {
                    columns: [1,2,3,5,6],
                    format: {
                        body: function ( data, row, column, node ) {
                            if(column === 4){
                               if(data=="true"){
                                data = 1;
                               }
                            }
                            return data;
                        }
                    },
                    // modifier: {
                    
                    //     search: 'applied',
                    //     order: 'applied',
                        
                    // }
                },

                filename: function(){
                    var currentDate = new Date();
                    var day = currentDate.getDate();
                    if(day < 10) day = '0' + day;
                    var month = currentDate.getMonth() + 1;
                    if(month < 10) month = '0' + month;
                    var year = currentDate.getFullYear();
                    var d = year + month + day;
                    return 'Transaction ' + d + Math.floor(Math.random() * 1000000);
                },
               

            }
        ],
		

				});
    //modifed by delwar
    $(".filter-orderid").keyup(function(e){
        table2.column(1).search($(this).val()).draw();
   });
    $(".filter-status").change(function(e){
        table2.column(5).search(e.target.value).draw();
    });

    /*$(".change_status").on('click',function () {
            var my_id_value = $(this).data('id');
            alert(my_id_value);
            $("input[name='orderid']").val(my_id_value);
    });*/

    $('#statusModal').on('show.bs.modal', function (event) {
      let id = $(event.relatedTarget).data('id') ;
      //alert(id);
      $("input[name='orderid']").val(id);
      //$(this).find('.modal-body input').val(bookId)
    });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      //$('#empTable').DataTable().ajax.data({'from':picker.startDate.format('YYYY-MM-DD')});
      //$('#empTable').data('ajax', { name: 'test' });
      //$('#empTable').DataTable().draw();
      /*$('#empTable').dataTable( {
          "ajax": {
            "url": "ajaxfile.php",
            "data": function ( d ) {
                d.from = picker.startDate.format('YYYY-MM-DD');
            }
          }
      });*/
      //$('#empTable').data({ name: 'test' });
      //$('#empTable').DataTable().draw();
      $('#empTable').DataTable().ajax.url("ajaxfile.php?from="+picker.startDate.format('YYYY-MM-DD')+"&to="+picker.endDate.format('YYYY-MM-DD')).load();
    });

    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#empTable').DataTable().ajax.url("ajaxfile.php").load();
    });
    //end modifed by delwar
    //Exportable table top
    
   $('.change_btn').click(function(e) {
	   
	    alert( "orderid is :" + $("input[name='orderid']").val());
        var orderid = $("input[name='orderid']").val();
        $.ajax({
            type: "POST",
            url: './transactionorderadmin.php',
            data: {orderid: orderid, change_status: 'change_status'},
            success: function(result) {
                $($(".status[orderid='"+$("input[name='orderid']").val()+"']")).html('true');
                $($("button[orderid='"+$("input[name='orderid']").val()+"']")).parent().html("");
                $("#statusModal").modal('hide');
            }
        });
    })

 //Delwar  

function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};

	
  
});

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



//////////////////////////////////////////////////////////////////////////////






	
$(function () {
    //Exportable table
    var table = $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {
                extend: 'excel',
                title: 'Excel',
                exportOptions: {
                    columns: [1,2,3,5,6],
                    format: {
                        body: function ( data, row, column, node ) {
                            if(column === 4){
                               if(data=="true"){
                                data = 1;
                               }
                            }
                            return data;
                        }
                    }
                },
                filename: function(){
                    var currentDate = new Date();
                    var day = currentDate.getDate();
                    if(day < 10) day = '0' + day;
                    var month = currentDate.getMonth() + 1;
                    if(month < 10) month = '0' + month;
                    var year = currentDate.getFullYear();
                    var d = year + month + day;
                    return 'Transaction ' + d + Math.floor(Math.random() * 1000000);
                },
            }
        ],
        "order": [[ 6, "desc" ]],
        "pageLength": 20
    });

    $(".filter-status").change(function(e){
        table.column(5).search(e.target.value).draw();
    });
    $(".filter-orderid").keyup(function(e){
        table.column(1).search($(this).val()).draw();
    });
    $(".filter-bank").keyup(function(e){
        table.column(3).search($(this).val()).draw();
    });

    $('input[name="daterange"]').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        opens: 'left',
        locale: {
            cancelLabel: 'Clear'
        }
    }, function(start, end){
        startDate = start;
        endDate = end;
        table.draw();
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $(".js-exportable").on("click",".change_status", function(){
        $("input[name='orderid']").val($(this).attr('orderid'));
    });
  
});

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var start_dt = startDate.format('YYYY-MM-DD HH:mm:ss');
        var end_dt = endDate.format('YYYY-MM-DD HH:mm:ss');
        if(start_dt <= data[6] && end_dt >= data[6]) return true;
        return false;
    }
);