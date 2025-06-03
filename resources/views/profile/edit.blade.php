<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 profile-section">

        <div class="form-card">
        @include('profile.partials.uploadImage')
           
            </div>



        <div class="form-card mt-3">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="form-card mt-3">
            @include('profile.partials.update-password-form')
        </div>


    </div>
    </div>

</x-app-layout>

