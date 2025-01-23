<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center w-full max-w-2xl mx-auto">
        <!-- User Profile Link -->
        <a href="profile" 
           class="text-gray-800 dark:text-gray-200 font-semibold text-xl hover:underline 
                  active:text-blue-500 focus:text-blue-500">
            {{ __('User Profile') }}
        </a>

        <!-- Shopping Profile Link -->
        <a href="{{ route('shopping-profile') }}" 
           class="text-gray-800 dark:text-gray-200 font-semibold text-xl hover:underline 
                  active:text-blue-500 focus:text-blue-500">
            {{ __('Shopping Profile') }}
        </a>
    </div>
</x-slot>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>


        </div>
    </div>
</x-app-layout>