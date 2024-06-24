$(document).ready(function() {
    // Toggle dropdown menu
    $(document).on("click", ".menu-button", function(event) {
        event.stopPropagation();
        var message_id = $(this).data("message_id");
        $(`#dropdown-menu-${message_id}`).toggleClass('hidden');
    });

    // Hide dropdown menu if clicked outside
    $(document).on("click", function(event) {
        if (!$(event.target).closest('.menu-button, .dropdown-menu').length) {
            $(".dropdown-menu").addClass('hidden');
        }
    });

    // Edit button functionality


    // Prevent message box overflow
    $(".message-text").css("word-break", "break-word");
});
