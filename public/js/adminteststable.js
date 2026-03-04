
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

function getTestType(id){
    if(id == 1){
        return 'Free';
    }
    else if(id == 0){
        return 'Premium';
    }
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
            title: 'Test Title'
            // className: "nk-tb-col"
        },
        // {
        //     data: "type_text",
        //     // className: "nk-tb-col"
        // },
        {
            data: "class_name",
            title: 'Educatiion Type / Class Group',
            render: function ( data, type, row ) {
                return `<div><div>${row.class_type}</div><div>${data}</div></div>`;
            }
            // className: "nk-tb-col"
        },
        {
            data: "test_cat",
            title: 'Test Categoty',
            // className: "nk-tb-col"
        },
        {
            data: "created_by",
            title: 'Created By / Created Date',
            render: function ( data, type, row ) {
                return `<div><div>${row.created_by}</div><div>${row.created_date}</div></div>`;
            }
            // className: "nk-tb-col"
        },
        {
            data: "sections",
            render: function ( data, type, row ) {
                return `<div>
                <div>${data}</div>
                <div> ${row.total_questions}</div></div>`;
            }
            // className: "nk-tb-col"
        },
        {
            data: "test_type",
            title: 'Test Type',
            render: function ( data, type, row ) {
                return `<div>
                <div>${getTestType(row.test_type)}</div>
                <div> ${row.test_fees} ${row.test_type == 0 || row.test_type == 3 ? '₹' : ''}</div></div>`;
            }
            // className: "nk-tb-col"
        },
        {
            data: "status",
            // className: "nk-tb-col"
        },
        {
            data: "featured",
            // className: "nk-tb-col"
        },
        {
            data: "actions",
            className: "text-end"
        }
        
        ],

    columnDefs: [{
        orderable: false,
        targets: [7]
    }],
    bFilter: true, // to display datatable search
});
$.fn.DataTable.ext.pager.numbers_length = 7;
