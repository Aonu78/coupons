<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('tournaments.admin.create.new')}}</h1>
                </div>

                @if( session()->has('success') )
                    <div
                        class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border"
                        role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.tournaments.save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-2">
                        <x-input-label for="game" :value="__('tournaments.admin.create.game')"/>
                        <select id="game" name="game"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option selected disabled>Choose the game</option>
                            @foreach($games as $game)
                                <option value="{{$game->game_uuid}}">{{$game->game_name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('game')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="finishing_trigger" :value="__('tournaments.admin.create.finishing_trigger')"/>
                        <select id="finishing_trigger" name="finishing_trigger"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option selected disabled>Choose the trigger</option>
                            <option value="time">Time</option>
                            <option value="players_count">Players Count</option>
                        </select>
                        <x-input-error :messages="$errors->get('finishing_trigger')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
