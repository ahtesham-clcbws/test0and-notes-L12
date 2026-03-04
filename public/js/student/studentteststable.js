
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
        console.log(row)
    },
    lengthMenu: [
        [10, 15, 30, 50],
        [10, 15, 30, 50]
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: "",
        type: "post",
    },
    columns: [
    {
        data: "title",
    },
    {
        data: "class_name",
    },
    {
        data: "created_date",
    },
    {
        data: "total_questions",
    },
    {
        data: "actions",
        className: "text-end"
    }
    
    ],

    columnDefs: [{
        orderable: false,
        targets: [4]
    }],
    searching: true, // to display datatable search
});
$.fn.DataTable.ext.pager.numbers_length = 4;
