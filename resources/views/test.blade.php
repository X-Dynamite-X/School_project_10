@extends('layouts.app')
@section('content')
    @foreach ($users as $user)
        @if ($user->status)
            <div>{{ $user->name }} ### <span data-user-status-{{ $user->id }}="{{ $user->status }}" id="user-status-{{ $user->id }}">online</span></div>
        @else
            <div>{{ $user->name }} ### <span data-user-status-{{ $user->id }}="{{ $user->status }}" id="user-status-{{ $user->id }}">offline </span></div>
        @endif
    @endforeach
@endsection
@section("js")

<script>


var pusher = new Pusher("0593f400f770b8b42f63", {
    cluster: "mt1",
    forceTLS: true,
    encrypted: true,
});

var channel = pusher.subscribe("user-status-channel");
var lastSeenAt = null;
channel.bind("user-status-changed", function (data) {
    if (lastSeenAt !== null) {
        const lastSeenDate = new Date(lastSeenAt);
        const now = new Date();
        const diffInMinutes = Math.floor((now - lastSeenDate) / 60000);
        console.log(diffInMinutes);
    }
    updateUserStatus(data.userId, data.status, lastSeenAt);
});
function updateUserStatus(userId, status, lastSeenAt) {
    const userElement = document.getElementById(`user-status-${userId}`);
    console.log(lastSeenAt);
    if (userElement) {
        const statusClass = status ? "text-green-500" : "text-red-500";
        const statusText = status ? "Online" : "Offline";
        var lastSeenText="No data available" ;
        if (lastSeenAt !== null) {
            lastSeenText = `Last seen ${lastSeenAt}`;
        }

        userElement.innerHTML = `
            <span class="${statusClass} inline">
                ${statusText}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" />
                </svg>
            </span>
            ${!status ? `<span class="block">${lastSeenText}</span>` : ""}
        `;
        userElement.setAttribute("data-last-seen", lastSeenAt);
    }
}
function updateLastSeenTime() {
    const userElements = document.querySelectorAll('[id^="user-status-"]');
    userElements.forEach((userElement) => {
        var  lastSeenAt = userElement.getAttribute("data-last-seen");
        if(lastSeenAt == null){
            astSeenAt = new Date();
        }
        if (lastSeenAt) {
            const lastSeenDate = new Date(lastSeenAt);
            if (!isNaN(lastSeenDate.getTime())) { // التأكد من صحة التاريخ
                const now = new Date();
                const diffInMinutes = Math.floor((now - lastSeenDate) / 60000);
                console.log(`now:  ${now}`);
                console.log(`lastSeenAt:  ${lastSeenAt}`);
                console.log(`lastSeenDate:  ${lastSeenDate}`);

                console.log(`diffInMinutes:  ${diffInMinutes}`);



                let lastSeenText;
                if (diffInMinutes < 1) {
                    lastSeenText = "Just now";
                } else if (diffInMinutes < 60) {
                    lastSeenText = `${diffInMinutes} minutes ago`;
                } else if (diffInMinutes < 1440) {
                    const diffInHours = Math.floor(diffInMinutes / 60);
                    lastSeenText = `${diffInHours} hours ago`;
                } else {
                    const diffInDays = Math.floor(diffInMinutes / 1440);
                    lastSeenText = `${diffInDays} days ago`;
                }

                const dataLastSeenElement = userElement.querySelector("#data-last-seen");
                if (dataLastSeenElement) {
                    dataLastSeenElement.textContent = `Last seen ${lastSeenText}`;
                }
            } else {
                console.error("Invalid date:", lastSeenAt);
            }
        }
    });
}
setInterval(updateLastSeenTime, 60000);

function setUserStatus(userId, status) {
    $.ajax({
        url: "/getUser",
        method: "POST",
        data: {
            user_id: userId,
            status: status ? 1 : 0,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("User status updated");
            lastSeenAt = response.user.last_seen_at;
            console.log(lastSeenAt);
            updateUserStatus(userId, status, lastSeenAt);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

let inactivityTime = function () {
    let time;
    let currentUserStatus = true;
    function setInactive() {
        if (currentUserStatus) {
            setUserStatus(userId, false);
            currentUserStatus = false;
        }
    }

    function resetTimer() {
        clearTimeout(time);
        if (!currentUserStatus) {
            setUserStatus(userId, true);
            currentUserStatus = true;
        }
        time = setTimeout(setInactive, 60000);
    }// تعيين الوقت إلى دقيقة واحدة

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onscroll = resetTimer;
    document.onclick = resetTimer;
};

inactivityTime();


public function getUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = (int) $request->input('status');

        $user = User::find($userId);
        if ($user) {
            $user->status = $status;
            if ($status == 0) {
                $user->last_seen_at = Carbon::now();
            }
            $user->save();
            event(new UserOnline($userId, $status));

            return response()->json(['status' => 'success', 'user' => $user]);
        }

        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    }
</script>
@endsection

