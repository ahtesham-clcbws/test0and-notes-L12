
async function deleteTest(test_id) {
    var formData = new FormData();
    formData.append('form_name', 'remove_test');
    formData.append('id', test_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('Question deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })  
}

$('#teststable').DataTable({
    responsive: {
        details: true
    },
    createdRow: function (row, data, dataIndex) {
        // Set the data-status attribute, and add a class
        // $(row).addClass('nk-tb-item');
    },
    lengthMenu: [
        [10, 15, 30, 50],
        [10, 15, 30, 50]
    ], // page length options
    bProcessing: true,
    serverSide: true,
    // scrollY: "400px",
    // scrollCollapse: true,
    ajax: {
        url: "", // json datasource
        type: "post",
        // data: {
        //     // key1: value1 - in case if we want send data with request
        // }
    },
    columns: [
    //     {
    //     data: "id",
    //     // className: "nk-tb-col nk-tb-col-check"
    // },
    {
        data: "title",
        // className: "nk-tb-col"
    },
    // {
    //     data: "type_text",
    //     // className: "nk-tb-col"
    // },
    {
        data: "class_name",
        // className: "nk-tb-col"
    },
    // {
    //     data: "created_by",
    //     // className: "nk-tb-col"
    // },
    {
        data: "test_date",
        // className: "nk-tb-col"
    },
    // {
    //     data: "sections",
    //     // className: "nk-tb-col"
    // },
    {
        data: "test_category",
        // className: "nk-tb-col"
    },
    // {
    //     data: "status",
    //     // className: "nk-tb-col"
    // },
    {
        data: "actions",
        className: "text-end"
    }
    
    ],

    columnDefs: [{
        orderable: false,
        targets: [4]
    }],
    bFilter: true, // to display datatable search
});
$.fn.DataTable.ext.pager.numbers_length = 4;
