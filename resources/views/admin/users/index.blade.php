<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('user.admin.title')}}</h1>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.email')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.type')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('user.admin.index.registration_date')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('user.admin.index.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ ucfirst($user->user_type) }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.users.edit', $user->id)}}">
                                    <x-secondary-button>
                                        {{__('user.admin.index.show_details')}}
                                    </x-secondary-button>
                                </a>
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
</x-admin-layout>
