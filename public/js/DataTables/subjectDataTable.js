$(document).ready(function () {
    var dataTable = $("#subject_table").DataTable({
        ajax: {
            url: "getSubject",
            type: "GET",
            dataSrc: function (json) {
                console.log("Received JSON:", json); // طباعة البيانات في وحدة التحكم للتأكد من الاستجابة
                if (json && json.data) {
                    return json.data;
                } else {
                    console.error("Invalid JSON response:", json);
                    return [];
                }
            },
        },
        processing: true,
        serverSide: true,
        columns: [
            { data: "id", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "name", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "subject_code", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "subjectInUser", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "success_mark", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "full_mark", className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap" },
            { data: "Action", className: "px-4 py-2 text-sm text-gray-900 text-center whitespace-nowrap" },
        ],
        columnDefs: [
            {
                targets: 0,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectId_" + rowData.id);
                },
            },
            {
                targets: 1,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectNameId_" + rowData.id);
                },
            },
            {
                targets: 2,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectCodeId_" + rowData.id);
                },
            },
            {
                targets: 3,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectInUserId_" + rowData.id);
                },
            },
            {
                targets: 4,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectSuccessMarkId_" + rowData.id);
                },
            },
            {
                targets: 5,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectFullMarkId_" + rowData.id);
                },
            },
            {
                targets: 6,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "subjectActionId_" + rowData.id);
                },
            },
        ],
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
    });
});
