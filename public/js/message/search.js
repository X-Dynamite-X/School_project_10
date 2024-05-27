$(document).ready(function() {
    $('.search').on('input', function() {
        var query = $(this).val().trim();
        $.ajax({
            type: "GET",
            url: "/search",
            data: { search: query },
            success: function (data) {
                console.log(data);
                $(".contacts_search").empty();
                if(query.length == 0){
                    $(".myContacts").removeClass("hidden");
                }
                else{
                    $(".myContacts").addClass("hidden");
                }
                for (let index = 0; index < data.length; index++) {
                    var user = data[index];
                    console.log(user);
                    if (user.id != userId && query.length !=0) {
                        var contact = `
                        <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                src="../../imageProfile/${user.image}"
                                alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">${user.name}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">${user.email}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h
                                    ago</time></p>
                        </div>
                    </li>
                    `;
                        $(".contacts_search").append(contact);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    });
});
