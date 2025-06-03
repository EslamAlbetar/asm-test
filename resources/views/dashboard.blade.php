<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-danger text-center" style="font-size: 28px !important; font-weight: 600;">
                    {{ __("! ليس لديك أي صلاحية للدخول الى النظام ") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
