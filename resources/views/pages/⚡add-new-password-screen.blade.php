<?php

use App\DTOs\PasswordDto;
use Livewire\Component;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

new class extends Component {
    public string $applicationName = '';
    public string $applicationUrl = '';
    public string $userName = '';
    public string $password = '';

    protected function rules(): array
    {
        $rules = [
            'applicationName' => 'required|string|max:255',
            'applicationUrl' => 'required|url|max:255',
            'password' => 'required|string',
        ];

        if (filter_var($this->userName, FILTER_VALIDATE_EMAIL)) {
            $rules['userName'] = 'required|email|max:255';
        } else {
            $rules['userName'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function storeNewPassword(): void
    {
        $this->validate();

        $uniqueRefId = $this->generateUniqueRefId();
        $secureKey = $uniqueRefId . "_" . strtolower(str_replace(" ", "_", $this->applicationName));

        $passwordDto = new PasswordDto(
            applicationName: $this->applicationName,
            applicationUrl: $this->applicationUrl,
            refId: $uniqueRefId,
            secureKey: $secureKey,
        );

        SecureStorage::set(key: $secureKey . "_username", value: $this->userName);
        SecureStorage::set(key: $secureKey . "_password", value: $this->password);

        \App\Models\Password::CreateNewPassword(passwordDto: $passwordDto);

        Dialog::toast('New password added successfully!');

        redirect()->route('home-screen');
    }

    protected function generateUniqueRefId(): string
    {
        do {
            $str = Str::uuid() . time() . rand(11111, 99999);
        } while (\App\Models\Password::whereRefId($str)->exists());

        return $str;
    }
};
?>

<div class="container mx-auto">
    <flux:callout>
        <flux:field>
            <flux:label>Application name</flux:label>
            <flux:input wire:model="applicationName"/>
            <flux:error name="applicationName"/>
        </flux:field>

        <flux:field>
            <flux:label>Application URL</flux:label>
            <flux:input
                    wire:model="applicationUrl"
                    x-data="{ prefix: 'https://' }"
                    x-init="
        if (!$el.value.startsWith(prefix)) {
            $el.value = prefix
        }
    "
                    @input="
        let value = $el.value.toLowerCase()

        // Always enforce prefix
        if (!value.startsWith(prefix)) {
            value = prefix
        }

        $el.value = value
    "/>
            <flux:error name="applicationUrl"/>
        </flux:field>

        <flux:field>
            <flux:label>User name / Email address</flux:label>
            <flux:input wire:model="userName"/>
            <flux:error name="userName"/>
        </flux:field>

        <flux:field>
            <flux:label>Password</flux:label>
            <flux:input wire:model="password" type="password" viewable/>
            <flux:error name="password"/>
        </flux:field>

        <flux:button variant="primary" color="green" icon="save" @class(['mt-5']) wire:click="storeNewPassword">Save</flux:button>
    </flux:callout>
</div>

