function showEditModal(id) {
    $.ajax({
        url: '/admin/getUserData/' + id,
        type: 'GET',
        success: function(response) {
            var user = response[0];
            var roles = response[1];
            var permissions = response[2];
            var isActev = permissions[0];
            var image = `imageProfile/${user.image}`;
            $.get("/templates/user/editUserModle.html", function (template) {
                var checked=""
                style="bg-red-400 text-white"
                if(isActev =="isActev"){
                    checked="checked"
                    style="bg-green-100 text-green-800"
                }
                var infoSubject = template
                    .replace(/\${id}/g, user.id)
                    .replace(/\${name}/g, user.name)
                    .replace(/\${email}/g, user.email)
                    .replace(/\${isActev}/g, isActev)
                    .replace(/\${checked}/g, checked)
                    .replace(/\${style}/g, style)
                    .replace(/\${imagePath}/g, "../../"+image)
                    .replace(/\${csrf_token}/g, csrf_token);
                $(`.editModle`).append(infoSubject);
                roles.forEach(function (role) {
                    var span = document.createElement("span");
                    span.setAttribute(
                        "id",
                        `userRole_${role}_${user.id}`
                    );
                    span.setAttribute(
                        "class",
                        "bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                    );
                    span.textContent = role;
                    var parentElement = document.getElementById(`userRoles_${user.id}`);
                    if (parentElement) {
                        parentElement.appendChild(span);
                    }
                });
            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function closeModalEditUser(userId) {
    var modal = document.querySelector("#editUser_" + userId);
    modal.classList.add("hidden");
    modal.remove();
}

function hideAllModals() {
    $('[id^="editUser_"]').addClass('hidden');
    $('[id^="editUser_"]').remove();

}

$(document).on('click', '.editUserButton', function() {
    var id = $(this).data("id");
    var form = $("#formEditUser_" + id)[0]; // Fetch the form element itself
    var formData = new FormData(form);
     // Add image field to FormData if it exists
     var imageFile = $("#editimgUesrProfile_" + id)[0].files[0];
     if(imageFile) {
         formData.append("image", imageFile);
     }
    $.ajax({
        type: form.method,
        url: form.action,
        data: formData,
        processData: false, // Don't process data (required with FormData)
        contentType: false,
        success: function (data) {
            console.log(data);
            var user = data[0];
            var permission = data[1];

            $("#errurMessageInputUserNameEdit_"+ user.id).text("");
            $("#errurMessageInputUserEmailEdit_"+ user.id).text("");
            $("#errurMessageInputImageEdit_"+ id).text("");
            $("#userNameId_" + user.id).text(user.name);
            $("#userEmailId_" + user.id).text(user.email);


            if (permission == "isActev") {
                $("#userActevSpanId_" + user.id).text(permission).addClass("bg-green-100 text-green-800").removeClass("bg-red-400 text-white");
            }
            else{
                $("#userActevSpanId_" + user.id).text(permission).addClass("bg-red-400 text-white").removeClass("bg-green-100 text-green-800");;

            }
            $('[id^="editUser_"]').addClass('hidden');
            $('[id^="editUser_"]').remove();
        },
        error: function (data) {
            var errur = data.responseJSON.message;
            console.log(data);
            console.log(data.statusText);
            console.log(errur);
            $("#errurMessageInputUserNameEdit_"+ id).text("");
            $("#errurMessageInputUserEmailEdit_"+ id).text("");
            $("#errurMessageInputImageEdit_"+ id).text("");
            $("#errurMessageInputUserNameEdit_"+ id).text(errur.name);
            $("#errurMessageInputUserEmailEdit_"+ id).text(errur.email);
            $("#errurMessageInputImageEdit_"+ id).text(errur.image);
            if(data.statusText = 'Content Too Large'){
                $("#errurMessageInputImageEdit_"+ id).text("The uploaded image is too large. Please choose an image with a smaller file size to proceed with saving.");

            }


        },
    });
});
function previewImage(input,id) {
    var file = input.files[0];
    console.log(file);
    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imageUser_'+id).attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
}
