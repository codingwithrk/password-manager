<?php

use Livewire\Component;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Alert\ButtonPressed;
use Native\Mobile\Facades\Browser;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

new class extends Component {
    public array $password = [];
    public string $usernameValue = '';
    public string $passwordValue = '';

    public string $deleteRecordId = '';

    public function mount(): void
    {
        $secureKey = data_get($this->password, 'secureKey');

        $this->usernameValue = SecureStorage::get(key: $secureKey . "_username") ?? '';
        $this->passwordValue = SecureStorage::get(key: $secureKey . "_password") ?? '';
    }

    public function openInAppBrowser(): void
    {
        Browser::inApp(data_get($this->password, 'applicationUrl'));
    }

    public function openSystemBrowser(): void
    {
        Browser::open(data_get($this->password, 'applicationUrl'));
    }

    public function deletePassword($deleteRecordId): void
    {
        $this->deleteRecordId = $deleteRecordId;
        Dialog::alert('Confirm', 'Are you sure?', ['❌ Cancel', '🗑️ Delete'])
            ->id('delete-confirm')
            ->show();
    }

    #[OnNative(ButtonPressed::class)]
    public function handleButton($index, $label, $id = null)
    {
        if ($id === 'delete-confirm' && $label === '🗑️ Delete') {
            $secureKey = data_get($this->password, 'secureKey');

            SecureStorage::delete(key: $secureKey . "_username");
            SecureStorage::delete(key: $secureKey . "_password");

            \App\Models\Password::whereId($this->deleteRecordId)->delete();

            Dialog::toast('Password deleted successfully!');

            $this->dispatch('passwordDeleted');
        }
    }
};
?>

<div>
    <flux:callout @class(['my-5'])>
        <div class="flex flex-col gap-5">
            <div class="font-semibold text-foreground flex items-center gap-5 mb-5">
                <flux:avatar src="https://www.google.com/s2/favicons?domain={{ data_get($password, 'applicationUrl') }}" size="xs"/>
                {{ data_get($password, 'applicationName') }}
            </div>

            <div class="flex justify-between">
                <flux:modal.trigger :name="data_get($password,'refId')">
                    <flux:button icon="eye" variant="primary" color="sky">View details</flux:button>
                </flux:modal.trigger>

                <flux:button icon="trash-2" variant="primary" color="red" wire:click="deletePassword('{{ data_get($password,'id') }}')">Delete</flux:button>
            </div>
        </div>
    </flux:callout>
    <flux:modal :name="data_get($password,'refId')" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ data_get($password, 'applicationName') }}</flux:heading>
                <flux:text class="mt-2">Copy your credentials</flux:text>
            </div>
            <div class="flex justify-around">
                <flux:button wire:click="openInAppBrowser" icon="smartphone">Open in app</flux:button>
                <flux:button wire:click="openSystemBrowser" icon="globe">Open in browser</flux:button>
            </div>
            <flux:input icon="at-symbol" label="Username / Email address" :value="$usernameValue" readonly copyable/>
            <flux:input icon="key" label="Password" type="password" :value="$passwordValue" readonly copyable/>
        </div>
    </flux:modal>
</div>