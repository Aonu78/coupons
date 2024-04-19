<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('games.admin.index.title')}}</h1>

                    <a href="{{route('admin.games.create')}}">
                        <x-primary-button class="ml-4">
                            {{__('games.admin.index.new')}}
                        </x-primary-button>
                    </a>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">{{__('games.admin.index.name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('games.admin.index.is_visible')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('games.admin.index.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ($games->currentPage() - 1) * $games->perPage() + $loop->index + 1 }}</td>
                            <td class="px-6 py-4">{{ $game->game_name }}</td>
                            <td class="px-6 py-4">{{ $game->game_visible ? __('games.admin.index.visible') : __('games.admin.index.not_visible') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.games.edit', $game->game_uuid)}}">
                                    <x-secondary-button>
                                        {{__('games.admin.index.edit')}}
                                    </x-secondary-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $games->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
