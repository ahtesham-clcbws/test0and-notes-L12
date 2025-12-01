$('#student_list_table').DataTable({
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
        data: "username",
        // className: "nk-tb-col"
    },
    // {
    //     data: "type_text",
    //     // className: "nk-tb-col"
    // },
    {
        data: "title",
        // className: "nk-tb-col"
    },
    {
        data: "test_attempt_date",
        // className: "nk-tb-col"
    },
    {
        data: "class_name",
        // className: "nk-tb-col"
    },
    // {
    //     data: "sections",
    //     // className: "nk-tb-col"
    // },
    // {
    //     data: "total_questions",
    //     // className: "nk-tb-col"
    // },
    // {
    //     data: "status",
    //     // className: "nk-tb-col"
    // },
    // {
    //     data: "actions",
    //     className: "text-end"
    // }
    
    ],

    columnDefs: [{
        orderable: false,
        targets: [3]
    }],
    bFilter: true, // to display datatable search
});
$.fn.DataTable.ext.pager.numbers_length = 3;