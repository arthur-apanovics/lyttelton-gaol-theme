var $ = jQuery.noConflict();

$.makeTable = function (mydata) {
    var table = $('<table border=1>');
    var tblHeader = "<tr>";
    for (var k in mydata[0]) tblHeader += "<th>" + k + "</th>";
    tblHeader += "</tr>";
    $(tblHeader).appendTo(table);
    $.each(mydata, function (index, value) {
        var TableRow = "<tr>";
        $.each(value, function (key, val) {
            TableRow += "<td>" + val + "</td>";
        });
        TableRow += "</tr>";
        $(table).append(TableRow);
    });
    return ($(table));
};

function init_convict_table(data) {
    $('#table').bootstrapTable({
        undefinedText: 'No value',
        data: data,
        pagination: true,
        pageSize: 25,
        search: true,
        striped: true,
        showToggle: true,
        smartDisplay: true,
        showColumns: true,
        showPaginationSwitch: true,
        detailView: true,
        onExpandRow: function (index, row, $detail) {
            // collapse others
            // $('#table').find('.detail-view').each(function () {
            //     if (!$(this).is($detail.parent())) {
            //         $(this).prev().find('.detail-icon').click()
            //     }
            // });



            $detail.html($.makeTable(row.convictions));
        }
    });
}
