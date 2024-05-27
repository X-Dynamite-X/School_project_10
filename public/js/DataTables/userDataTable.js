$(document).ready(function () {
    var dataTable = $("#user_table").DataTable({
        ajax: {
            url: "getUser",
            dataSrc: "data",
        },
        processing: true,
        serverSide: true,
        columns: [
            {
                data: "id",
                className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
            },
            {
                data: "name",
                className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
            },
            {
                data: "email",
                className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
            },
            {
                data: "userInSubject",
                className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
            },
            {
                data: "actev",
                className: "px-4 py-2 text-sm text-gray-900 text-center whitespace-nowrap",
            },
            {
                data: "roles",
                className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
            },
            {
                data: "Action",
                className: "px-4 py-2 text-sm text-gray-900 text-center whitespace-nowrap",
            },
        ],
        columnDefs: [
            {
                targets: 0,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userId_" + rowData.id);
                },
            },
            {
                targets: 1,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userNameId_" + rowData.id);
                },
            },
            {
                targets: 2,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userEmailId_" + rowData.id);
                },
            },
            {
                targets: 3,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userSubjectId_" + rowData.id);
                },
            },
            {
                targets: 4,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userActevId_" + rowData.id);
                },
            },
            {
                targets: 5,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userRoleId_" + rowData.id);
                },
            },

            {
                targets: 6,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr("id", "userActionId_" + rowData.id);
                },
            },
        ],
    });
});
