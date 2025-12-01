$('#questionstable').DataTable({
    responsive: {
        details: true
    },
    createdRow: function (row, data, dataIndex) {
        console.log(data);
        // Set the data-status attribute, and add a class
        // $(row).addClass('nk-tb-item');
    },
    lengthMenu: [
        [10, 15, 30, 50],
        [10, 15, 30, 50]
    ],
    bProcessing: true,
    serverSide: true,
    // scrollY: "400px",
    scrollCollapse: true,
    ajax: {
        url: "",
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
            data: "question",
        },
        {
            data: "type",
        },
        {
            data: "education",
            className: "text-wrap"
        },
        {
            data: "class",
            className: "text-wrap"
        },
        {
            data: "board",
            className: "text-wrap"
        },
        {
            data: "subject",
            className: "text-wrap"
        },
        {
            data: "subject_part",
            className: "text-wrap"
        },
        {
            data: "lesson_chapter",
            className: "text-wrap"
        },
        {
            data: "creator_name",
        },
        {
            data: "checker_name",
        },
        {
            data: "created",
        },
        {
            data: "updated",
        },
        {
            data: "status",
        },
        {
            data: "actions",
            className: "text-end"
        }
    ],

    // columnDefs: [{
    //     orderable: false,
    //     targets: [5]
    // }],
    bFilter: true, // to display datatable search
});
$.fn.DataTable.ext.pager.numbers_length = 7;
