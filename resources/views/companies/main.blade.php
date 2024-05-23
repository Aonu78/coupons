<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dLbjk5S2ExeIzEH1Heuw0CaqKuQghNrHzS10U3Aa">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link rel="preload" as="style" href="/build/assets/app-1fd46269.css" />
    <link rel="modulepreload" href="/build/assets/app-7c0572f8.js" />
    <link rel="stylesheet" href="/build/assets/app-1fd46269.css" />
    <script type="module" src="/build/assets/app-7c0572f8.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('company.main') }}">
                                <x-application-logo
                                    class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('company.main')" :active="request()->routeIs('company.main')">
                                {{ __('navigation.home') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <form method="POST" action="{{ route('company.locale') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('company.logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        <input type="hidden" name="locale"
                                            value="{{ app()->getLocale() === 'jp' ? 'en' : 'jp' }}">
                                        {{ app()->getLocale() === 'jp' ? 'English' : 'Japanese' }}
                                    </x-dropdown-link>
                                </form>
                                <form method="POST" action="{{ route('company.logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('company.logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('navigation.logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a class="block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-left text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out"
                        href="/coupons">
                        クーポン
                    </a>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">admin@company.com</div>
                        <div class="font-medium text-sm text-gray-500">admin@company.com</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <a class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                            href="/profile">
                            Profile
                        </a>

                        <a class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                            href="/profile/company">
                            Company
                        </a>

                        <!-- Authentication -->
                        <form method="POST" action="/logout">
                            <input type="hidden" name="_token" value="dLbjk5S2ExeIzEH1Heuw0CaqKuQghNrHzS10U3Aa"
                                autocomplete="off">
                            <a class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                                href="/logout"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="close" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            @endif
    
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                    <button type="button" class="close" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            @endif

        </div>
        <!-- Page Content -->
        <main>
            
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" integrity="sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7" style="overflow-x: auto;">
                            
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
                            {{ __('What Types of Users Do Wants Create?') }}
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
                            {{-- <select required id="user_type" name="user_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4">
                                <option value="" disabled selected>Select User Type</option>
                                <option value="admin">Admin</option>
                                <option value="company">Company</option>
                                <option value="agent">Agent</option>
                                <option value="user">User</option>
                            </select> --}}
                            <x-text-input
                                id="user_type"
                                name="user_type"
                                class="mt-1 block w-3/4"
                                value="agent"
                                placeholder="{{ __('User Type') }}"
                                required
                                readonly
                            />
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

            
        </main>
    </div>
</body>

</html>
