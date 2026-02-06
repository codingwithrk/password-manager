<?php

use Livewire\Component;
use Native\Mobile\Facades\Browser;

new class extends Component {
    public function openPrivacyPolicy(): void
    {
        Browser::inApp('https://codingwithrk.com/landing-page/password-manger/privacy-policy');
    }

    public function openSourceCode(): void
    {
        Browser::inApp('https://github.com/codingwithrk/password-manager.git');
    }
};
?>

<div class="container mx-auto">
    <div class="flex flex-col gap-5">
        <flux:modal.trigger name="about-app">
            <flux:button>About app</flux:button>
        </flux:modal.trigger>
        <flux:button wire:click="openPrivacyPolicy">Privacy policy</flux:button>
    </div>
    <flux:modal name="about-app" class="md:w-96">
        <div class="space-y-6">
            <flux:heading>About app</flux:heading>
            <flux:separator :text="config('nativephp.version')"/>
            <flux:text>This app was mainly designed to store our personal passwords in our mobile only.</flux:text>
            <flux:text>Whenever you need you can simply get them without any internet connection.</flux:text>
            <flux:text><span style="color: green">Don't worry about security.</span> Because every password has been saved in your mobile phone only no cloud no internet.</flux:text>
            <flux:text>This mobile app is
                <flux:callout.link wire:click="openSourceCode">open source</flux:callout.link>
                so you can check and develop your own app using the code of this mobile app.
            </flux:text>

            <flux:heading>Developed by using</flux:heading>
            <div class="flex flex-col gap-3">
                <flux:callout.link href="https://laravel.com/">Laravel</flux:callout.link>
                <flux:callout.link href="https://livewire.laravel.com/">Livewire</flux:callout.link>
                <flux:callout.link href="https://fluxui.dev/">FluxUI</flux:callout.link>
                <flux:callout.link href="https://nativephp.com/">NativePHP</flux:callout.link>
            </div>
        </div>
    </flux:modal>
</div>