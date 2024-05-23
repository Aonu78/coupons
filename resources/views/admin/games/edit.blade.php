<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{ $game->game_name }}</h1>
                </div>

                <small class="text-gray-900 dark:text-gray-100">{{ __('games.admin.edit.system_id') }} {{$game->game_uuid}}</small>

                @if( session()->has('success') )
                    <div class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{route('admin.games.update', $game->game_uuid)}}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-2">
                        <x-input-label for="name" :value="__('games.admin.edit.name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $game->game_name)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="description" :value="__('games.admin.edit.description')"/>
                        <textarea
                            name="description"
                            id="description"
                            cols="3"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        >{{ old('description', $game->game_description) }}</textarea>

                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <label for="game_visible" class="inline-flex items-center">
                            <input
                                id="game_visible"
                                type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="game_visible"
                                @if($game->game_visible) checked @endif
                            >
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('games.admin.edit.is_visible') }}</span>
                        </label>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="design" :value="__('games.admin.edit.cover_image')"/>
                        <div style="display: flex;">
                            <img src="{{asset($game->game_image) }}" alt="" width="35px" style="margin-right: 20px;">

                            <x-text-input id="design" class="block mt-1 w-full" type="file" name="design"
                                      :value="old('design')" accept="image/*"/>
                        </div>
                        <x-input-error :messages="$errors->get('design')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('games.admin.edit.save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
