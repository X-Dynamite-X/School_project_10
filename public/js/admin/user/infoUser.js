function showInfoModal(id) {
    $.ajax({
        url: '/admin/getUserData/' + id,
        type: 'GET',
        success: function(response) {
            var user = response[0];
            var roles = response[1];
            var permissions = response[2];
            console.log(user.image)
            var image = `imageProfile/${user.image}`;
            $.get("/templates/user/infoUserModle.html", function (template) {
                var infoSubject = template
                    .replace(/\${id}/g, user.id)
                    .replace(/\${name}/g, user.name)


                    .replace(/\${imagePath}/g, "../../"+image)
                    .replace(/\${email}/g, user.email);
                $(`.infoModle`).append(infoSubject);
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
                permissions.forEach(function (permission) {
                    var span = document.createElement("span");
                    span.setAttribute(
                        "id",
                        `userPermission_${permission}_${user.id}`
                    );
                    if(permission=='isActev'){
                        span.setAttribute(
                            "class",
                            "bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                        );
                    }
                    else{
                        span.setAttribute(
                            "class",
                            "bg-red-400 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                    );
                }



                    span.textContent = permission;
                    var parentElement = document.getElementById(`userPermission_${user.id}`);
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
function closeModalInfoUser(userId) {
    var modal = document.querySelector("#infoUser_" + userId);
    modal.classList.add("hidden");
    modal.remove("#infoUser_" + userId);
}

function hideAllModals() {
    // يجعل كل الـ Modals مخفية
    $('[id^="infoUser_"]').addClass("hidden");
}
