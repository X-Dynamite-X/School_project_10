// $(document).ready(function () {
//     var dataTable = $("#userInfoTable").DataTable({
//         ajax: {
//             url: "getUserInfo",
//             type: "GET",
//             dataSrc: function (json) {
//                 console.log("Received JSON:", json); // طباعة البيانات في وحدة التحكم للتأكد من الاستجابة
//                 if (json && json.data) {
//                     return json.data;
//                 } else {
//                     console.error("Invalid JSON response:", json);
//                     return [];
//                 }
//             },
//         },
//         processing: true,
//         serverSide: true,
//         columns: [
//             {
//                 data: "subjectName",
//                 className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
//             },
//             {
//                 data: "subjectCode",
//                 className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
//             },
//             {
//                 data: "SuccessMark",
//                 className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
//             },
//             {
//                 data: "userMark",
//                 className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
//             },
//             {
//                 data: "FullMark",
//                 className: "px-4 py-2 text-sm text-gray-900 whitespace-nowrap",
//             },
//         ],
//         columnDefs: [
//             {
//                 targets: 0,
//                 createdCell: function (td, cellData, rowData, row, col) {
//                     $(td).attr("id", "userSubjectNameId_" + rowData.id);
//                 },
//             },
//             {
//                 targets: 1,
//                 createdCell: function (td, cellData, rowData, row, col) {
//                     $(td).attr("id", "userSubjectCodeId_" + rowData.id);
//                 },
//             },
//             {
//                 targets: 2,
//                 createdCell: function (td, cellData, rowData, row, col) {
//                     $(td).attr("id", "userSubjectSuccessMarkId_" + rowData.id);
//                 },
//             },
//             {
//                 targets: 3,
//                 createdCell: function (td, cellData, rowData, row, col) {
//                     $(td).attr("id", "userSubjectMarkId_" + rowData.id);
//                 },
//             },
//             {
//                 targets: 4,
//                 createdCell: function (td, cellData, rowData, row, col) {
//                     $(td).attr("id", "userSubjectFullMarkId_" + rowData.id);
//                 },
//             },
//         ],
//         paging: true,
//         searching: true,
//         info: true,
//         lengthChange: true,
//     });
// });
