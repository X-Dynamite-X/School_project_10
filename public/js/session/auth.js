// Pusher.logToConsole = true;

var channel = pusher.subscribe("user-status-channel");
var lastSeenAt = null;
channel.bind("user-status-changed", function (data) {
    if (lastSeenAt !== null) {
        const lastSeenDate = new Date(lastSeenAt);
        const now = new Date();
        const diffInMinutes = Math.floor((now - lastSeenDate) / 60000);
    }
    updateUserStatus(
        data.userId,
        data.status,
        data.status ? null : new Date().toISOString()
    );
});
function updateUserStatus(userId, status, lastSeenAt) {
    const userElement = document.getElementById(`user-status-${userId}`);
    if (userElement) {
        const statusClass = status
            ? "text-green-500 "
            : "text-red-500 inline-block flex justify-end";
        const statusText = status ? "Online" : "Offline";
        let lastSeenText = "I'm not login yeat";
        if (!status && lastSeenAt !== null) {
            lastSeenText = `Last seen Just now`;
        }
        userElement.innerHTML = `
            <span class="${statusClass} inline">
                ${statusText}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" />
                </svg>
            </span>
            ${
                !status
                    ? `<span class="block" id="data-last-seen-${userId}">${lastSeenText}</span>`
                    : ""
            }
        `;
        userElement.setAttribute("data-last-seen", status ? null : lastSeenAt);
    }
}
function updateLastSeenTime() {
    const userElements = document.querySelectorAll('[id^="user-status-"]');
    userElements.forEach((userElement) => {
        const lastSeenAt = userElement.getAttribute("data-last-seen");
        if (lastSeenAt) {
            const lastSeenDate = new Date(lastSeenAt);
            if (!isNaN(lastSeenDate.getTime())) {
                const now = new Date();
                const diffInMinutes = Math.floor(
                    (now - lastSeenDate.getTime()) / 60000
                );
                let lastSeenText;
                if (diffInMinutes < 1) {
                    lastSeenText = "Last  seen Just now";
                } else if (diffInMinutes < 60) {
                    lastSeenText = `Last seen ${diffInMinutes} m ago`;
                } else if (diffInMinutes < 1440) {
                    const diffInHours = Math.floor(diffInMinutes / 60);
                    lastSeenText = `Last seen ${diffInHours} h ago`;
                } else {
                    const diffInDays = Math.floor(diffInMinutes / 1440);
                    lastSeenText = `Last seen ${diffInDays} d ago`;
                }
                const dataLastSeenElement = userElement.querySelector(
                    `#data-last-seen-${userElement.id.split("-")[2]}`
                );
                if (dataLastSeenElement) {
                    dataLastSeenElement.textContent = `${lastSeenText}`;
                }
            }
        }
    });
}
setInterval(updateLastSeenTime, 5000);
document.addEventListener("DOMContentLoaded", function () {
    let currentUserStatus = true;
    function fetchUserStatus() {
        $.ajax({
            url: "/getUserStatus",
            method: "GET",
            data: {
                user_id: userId,
            },
            success: function (response) {
                if (response.status === "success") {
                    currentUserStatus = response.user.status === 1;
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to fetch user status:", xhr.responseText);
            },
        });
    }
    function setInactive() {
        if (currentUserStatus) {
            setUserStatus(userId, false);
            currentUserStatus = false;
        }
    }
    function resetTimer() {
        clearTimeout(time);
        if (!currentUserStatus) {
            userInteracted = true;

            setUserStatus(userId, true);
            console.log("done");

            currentUserStatus = true;
        }
        time = setTimeout(setInactive, 600000);
    }
    function setUserStatus(userId, status) {
        $.ajax({
            url: "/setUserStatus",
            method: "POST",
            data: {
                user_id: userId,
                status: status ? 1 : 0,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log("User status updated");
                if (status) {
                    lastSeenAt = null;
                } else {
                    lastSeenAt = new Date();
                }
                updateUserStatus(userId, status, lastSeenAt);
            },
            error: function (xhr, status, error) {
                console.error(
                    "Failed to update user status:",
                    xhr.responseText
                );
            },
        });
    }
    window.addEventListener("unload", function () {
        if (currentUserStatus) {
            setInactive();
            userInteracted = true;
            localStorage.setItem("userStatus", "offline");
            localStorage.setItem("openBrowser", "true");
        }
    });

    window.addEventListener("load", function () {
        // let notification_sound = new Audio('../../sounds/massege_ting.mp3');

        if (localStorage.getItem("openBrowser") == "true") {
            if (localStorage.getItem("userStatus") === "offline") {
                currentUserStatus = true;
                console.log(currentUserStatus);
                setUserStatus(userId, true);
            }
            localStorage.setItem("openBrowser", "false");
        }
    });
    fetchUserStatus();
    let time;
    window.onload = resetTimer;
    window.onbeforeunload = resetTimer;
    window.onloadstart = resetTimer;
    window.onsta = resetTimer;


    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onscroll = resetTimer;
    document.onclick = resetTimer;
    document.onbeforeinput = resetTimer;
});

let audio;
let notification_sound;
let userInteracted = false;

const resetTimer = () => {
    userInteracted = true;
    removeEventListeners();
};

const removeEventListeners = () => {
    window.removeEventListener("load", resetTimer);
    document.removeEventListener("mousemove", resetTimer);
    document.removeEventListener("keypress", resetTimer);
    document.removeEventListener("scroll", resetTimer);
    document.removeEventListener("click", resetTimer);

};

// إضافة مستمعات للأحداث
window.addEventListener("load", resetTimer);

document.addEventListener("mousemove", resetTimer);
document.addEventListener("keypress", resetTimer);
document.addEventListener("scroll", resetTimer);
document.addEventListener("click", resetTimer);
notification_sound = document.getElementById("notification_sound");
