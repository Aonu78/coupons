<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('tournaments.admin.details.title')}}</h1>
                </div>

                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.system_id')}}</b> {{$tournament->tournament_uuid}}
                </p>
                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.status')}}</b> {{$tournament->tournament_status->title()}}
                </p>
                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.players')}}</b> {{$tournament->players()->count()}}
                </p>
                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.finishing_trigger')}}</b> {{$tournament->tournament_finishing_trigger->title()}}
                </p>

                @if($tournament->tournament_finishing_trigger->value == 'players_count')
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('tournaments.admin.details.total_slots')}}</b> 5
                    </p>

                    @if($tournament->tournament_status->value !== 'finished')
                        <p class="my-3 text-gray-900 dark:text-gray-100">
                            <b>{{__('tournaments.admin.details.available_slots')}}</b> {{5 - $tournament->players()->count()}}
                        </p>
                    @endif
                @else
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('tournaments.admin.details.starts_at')}}</b> {{\Carbon\Carbon::parse($tournament->tournament_starts_at)->format('Y-m-d H:i')}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('tournaments.admin.details.ends_at')}}</b> {{\Carbon\Carbon::parse($tournament->tournament_ends_at)->format('Y-m-d H:i')}}
                    </p>
                @endif

                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.joining_bet')}}</b> CP {{$tournament->tournament_bet}}
                </p>

                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('tournaments.admin.details.prize_pool')}}</b> CP {{$tournament->tournament_bet * $tournament->players()->count()}}
                </p>
            </div>

            @if($tournament->players->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7 mt-5">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">
                            {{__('tournaments.admin.players.title')}}
                        </h1>
                    </div>

                    <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-left">
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">{{__('tournaments.admin.players.user_name')}}</th>
                            <th scope="col" class="px-6 py-3">{{__('tournaments.admin.players.status')}}</th>
                            <th scope="col" class="px-6 py-3">{{__('tournaments.admin.players.score')}}</th>
                            <th scope="col" class="px-6 py-3">{{__('tournaments.admin.players.winner')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournament->players as $player)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $loop->index + 1 }}</td>
                                <td class="px-6 py-4">{{ $player->user->name }}</td>
                                <td class="px-6 py-4">{{ $player->player_status->title() }}</td>
                                <td class="px-6 py-4">{{ $player->player_score ?? 0}}</td>
                                <td class="px-6 py-4">{{ $player->is_winner ? __('tournaments.admin.players.yes') : __('tournaments.admin.players.no') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
