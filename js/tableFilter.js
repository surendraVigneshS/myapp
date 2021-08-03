$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex) {
        var selection  = $('#dateFilter1').val();
        var today = $('#currentDate').val();
        var lastweek = $('#lastWeek').val();
        var lastmonth = $('#lastMonth').val();
        var date = new Date(today);
        var lastw = new Date(lastweek);
        var lastm = new Date(lastmonth);
        var datevalue = new Date( data[0] );
        if(selection == 1){
            var lastweek = lastw.setDate(lastw.getDate());
        }
        if(selection == 2){
            var lastmonth = lastm.setDate(lastm.getDate());
        }
        var datevalue = datevalue.setDate(datevalue.getDate());
        console.log(lastweek);
        console.log(datevalue);
        if(selection == null){
            return true;
        }
        if(datevalue >= lastweek){
            return true;
        }
        if(datevalue <= lastmonth){
            return true;
        }
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex) {
        var selection  = $('#dateFilter2').val();
        var today = $('#currentDate').val();
        var lastweek = $('#lastWeek').val();
        var lastmonth = $('#lastMonth').val();
        var date = new Date(today);
        var lastw = new Date(lastweek);
        var lastm = new Date(lastmonth);
        var datevalue = new Date( data[0] );
        if(selection == 1){
            var lastweek = lastw.setDate(lastw.getDate());
        }
        if(selection == 2){
            var lastmonth = lastm.setDate(lastm.getDate());
        }
        var datevalue = datevalue.setDate(datevalue.getDate());
        if(selection == null){
            return true;
        }
        if(datevalue >= lastweek){
            return true;
        }
        if(datevalue <= lastmonth){
            return true;
        }
    }
);
$(document).ready(function() { 
    var table1 = $('#filterTable1').DataTable();
        $('#dateFilter1').on('change', function(){
        table1.draw();
    });
    var table2 = $('#filterTable2').DataTable();
    $('#dateFilter2').on('change', function(){
        table2.draw();
    });
});
