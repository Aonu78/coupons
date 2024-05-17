<x-app-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" integrity="sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7" style="overflow-x: auto;">
                <div class="pb-3 flex flex-row justify-end cus-display">
                    <a href="{{ route('admin.users.download.csv') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Download CSV</a>
                </div>
                <div class="flex flex-row justify-between cus-display">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('user.admin.title')}}</h1>
                    <input placeholder="search user" id="searchInput" class="search-width inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    {{-- <button type="button" id="createUserButton" class="btn btn-primary inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150" data-toggle="modal" data-target="#createUserModal">
                        Create User
                    </button> --}}
                    {{-- <button id="createUserButton" type="submit" class="btn" x-on:click.prevent="$dispatch('open-modal', 'create-user')">
                        <i class="fa-solid fa-plus fa-bold"></i>
                    </button> --}}
                    {{-- <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                >{{ __('Delete Account') }}</x-danger-button> --}}
                <button type="submit" class="btn inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-creation')">
                    <i class="fa-solid fa-plus fa-bold"></i>
                </button>
                </div>

                <table id="myTable" class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.email')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.type')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.referral')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.registration_date')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('user.admin.index.actions')}}</th>
                        <th scope="col" class="px-6 py-3 text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ ucfirst($user->user_type) }}</td>
                            <td class="px-6 py-4">{{ $user->referral_code }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.users.edit', $user->id)}}">
                                    <x-secondary-button>
                                        {{__('user.admin.index.show_details')}}
                                    </x-secondary-button>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('alluser.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                            
                                    <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                                        <x-danger-button> <i class="fa-solid fa-trash-can"></i></x-danger-button>
                                    </button>
                                </form>
                            </td>                                                                                    
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-modal name="confirm-user-creation" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.newuser.register') }}" class="p-6">
            @csrf
            <input
            type="hidden"
            id="user_id"
            name="user_id"
            class="mt-1 block w-3/4"
            value="{{Auth::id()}}"
            required
        />        
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Create New Agent Here') }}
            </h2>
            <div class="mt-6">
                <x-input-label for="User Name" value="{{ __('name') }}" class="sr-only" />
                <x-text-input
                    id="name"
                    name="name"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('User Name') }}"
                    required
                />
            </div>
            <div class="mt-6">
                <x-input-label for="Email" value="{{ __('email') }}" class="sr-only" />
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Email') }}"
                    required
                />
            </div>
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" 
                    required
                />
            </div>
            <div class="mt-6">
                <select required id="user_type" name="user_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4">
                    <option value="" disabled selected>Select User Type</option>
                    <option value="admin">Admin</option>
                    <option value="company">Company</option>
                    <option value="agent">Agent</option>
                    <option value="user">User</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12a1 1 0 01-.7-.29l-4-4a1 1 0 111.41-1.42L10 9.59l3.3-3.3a1 1 0 111.4 1.42l-4 4a1 1 0 01-.7.29z"/></svg>
                </div>
            </div>
            
            
            
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Create Account') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
    <style>
        .fa-bold{
            color: white;
            font-weight: bold;
        }
        .btn{
            background: green;
            /* width: 40px; */
            border-radius: 8px;
        }
        .search-width{
                width: 60%;
            }
        @media screen and (max-width: 500px) {
            .cus-display
            {
                display: block !important;
            }
            .search-width{
                width: 100%;
            }
        }
    </style>
    <script>
        function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tbody = table.getElementsByTagName("tbody")[0];
        tr = tbody.getElementsByTagName("tr");
    
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            var matchFound = false;
            for (var j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    matchFound = true;
                    break; 
                }
            }
            if (matchFound) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    
    document.getElementById("searchInput").addEventListener("input", filterTable);
    
        </script>
        
        
</x-app-layout>
