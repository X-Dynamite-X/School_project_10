<div class="flex flex-col my_h_93 bg-gray-800 text-white">
    <div class="px-4 py-5">
        <h1 class="text-2xl font-bold">Company Name</h1>
        <p class="text-gray-400">Dashboard</p>
    </div>
    <nav class="flex-grow w-64 bg-gray-800 text-white p-4">
        <ul class="space-y-2">
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('user_index') }}"
                    class="flex items-center p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    <i class="fas fa-users mr-2"></i>
                    Users
                </a>
            </li>
            <li>
                <a href="{{ route('subject_index') }}"
                    class="flex items-center p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    <i class="fas fa-cog mr-2"></i>
                    Subjects
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}"
                    class="flex items-center p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    <i class="fas fa-chart-bar mr-2"></i>
                    App
                </a>
            </li>

        </ul>
    </nav>
    <div class="px-4 py-5">
        <p class="text-gray-400">© 2023 Company Name</p>
    </div>
</div>
