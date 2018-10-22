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

$.makeConTable = function (convictions) {
    var table = $('<table>');
    var tblHeader = "<tr>";

    tblHeader += '<th>Offence</th>';
    tblHeader += '<th>Sentence</th>';
    tblHeader += '<th style="width: 80px;">Year</th>'; // TODO to CSS

    tblHeader += "</tr>";
    $(tblHeader).appendTo(table);

    $.each(convictions, function (index, conviction) {
        var tableRow = "<tr>";
        tableRow += "<td>" + conviction.offence_crime + "</td>";
        tableRow += "<td>" + conviction.offence_sentence+ "</td>";
        tableRow += "<td>" + conviction.gazette_publication_year+ "</td>";
        tableRow += "</tr>";
        $(table).append(tableRow);
    });

    return ($(table));
};

function init_convict_table(data) {
    $('#table').bootstrapTable({
        classes: 'table table-no-bordered',
        undefinedText: 'No value',
        data: data,
        pagination: true,
        pageSize: 25,
        search: true,
        // striped: true,
        showToggle: true,
        smartDisplay: true,
        showColumns: true,
        showPaginationSwitch: true,
        detailView: true,
        // EVENTS
        onExpandRow: function (index, row, $detail) {
            var dTable = $.makeConTable(row.convictions);
            $detail.html(dTable);
        },
        onClickRow: function (row, $element, field) {
            console.log('');
        }
    });
}

function full_name_formatter(value, row, index) {
    return '<a href="'+ row.post_data.guid +'">'+ row.bio_name + ' ' + row.bio_surname +'</a>';
}