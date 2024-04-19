<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('tournaments.admin.index.title')}}</h1>

                    <a href="{{route('admin.tournaments.create')}}">
                        <x-primary-button class="ml-4">
                            {{__('tournaments.admin.index.new')}}
                        </x-primary-button>
                    </a>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">{{__('tournaments.admin.index.game_name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('tournaments.admin.index.joining_bet')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('tournaments.admin.index.status')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('tournaments.admin.index.finishing_trigger')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('tournaments.admin.index.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournaments as $tournament)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ($tournaments->currentPage() - 1) * $tournaments->perPage() + $loop->index + 1 }}</td>
                            <td class="px-6 py-4">{{ $tournament->game->game_name }}</td>
                            <td class="px-6 py-4">CP {{ $tournament->tournament_bet }}</td>
                            <td class="px-6 py-4">{{ $tournament->tournament_status->title() }}</td>
                            <td class="px-6 py-4">{{ $tournament->tournament_finishing_trigger->title() }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.tournaments.details', $tournament->tournament_uuid)}}">
                                    <x-secondary-button>
                                        {{ __('Show Details') }}
                                    </x-secondary-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $tournaments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
