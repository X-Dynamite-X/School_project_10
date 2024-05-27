<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 ">
                    <div class="sm:flex sm:items-start w-full">

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-center w-full">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Create User
                            </h3>
                            <div class="mt-2 ">

                                <form action="{{ route('user_store') }}" id="formUser" method="post">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name"
                                            class="block text-gray-700 text-sm font-bold mb-2">User Name</label>
                                        <input type="text" name="name" id="nameUser"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        <span class="sm:text-red-500 " id="errurMessageInputUser"> </span>

                                    </div>
                                    <div class="mb-4">
                                        <label for="email"
                                            class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                        <input type="email" name="email" id="emailUser"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        <span class="sm:text-red-500 " id="errurMessageInputEmailUser"> </span>

                                    </div>
                                    <div class="mb-4">
                                        <label for="password"
                                            class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        <span class="sm:text-red-500 " id="errurMessageInputPassword"> </span>
                                    </div>
                                    </div>
                                    <div class="mb-4">
                                        <label  for="password_confirmation"
                                            class="block text-gray-700 text-sm font-bold mb-2">Confirmation Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"required autocomplete="new-password"
                                            >
                                        <span class="sm:text-red-500 "id="errurMessageInputPasswordConfirmation"> </span>
                                    </div>
                            </div>
                        </div>
                    </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="createUser"
                        class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">Create</button>
                    </form>

                    <button type="button"onclick="closeModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
