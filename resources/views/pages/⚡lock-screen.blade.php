<?php

use App\Models\LockPin;
use Livewire\Component;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Biometric\Completed;
use Native\Mobile\Facades\Biometrics;

new class extends Component {

    public bool $firstTime = true;
    public array $securityQuestions = [
        'What was the name of your first pet?',
        'What was the make and model of your first car?',
        'In what city were you born?',
        'What is your favorite book?'
    ];

    // New Pin
    public string $newPin = '';
    public string $selectedSecurityQuestion = '';
    public string $securityAnswer = '';

    // Unlock using pin
    public string $unlockPin = '';

    // Forgot pin
    public ?LockPin $lockPin = null;
    public string $forgotAnswer = '';
    public string $resetPin = '';

    public function mount(): void
    {
        $this->lockPin = LockPin::getFirstRecord();
        if (LockPin::checkForFirstRecord()) {
            $this->firstTime = false;
            $this->openBiometric();
        }
    }

    public function openBiometric(): void
    {
        Biometrics::prompt();
    }

    #[OnNative(Completed::class)]
    public function handle(bool $success)
    {
        if ($success) {
            redirect()->route('home-screen');
        }
    }

    public function setNewPin(): void
    {
        $this->validate([
            'newPin' => 'required|digits:4',
            'selectedSecurityQuestion' => 'required',
            'securityAnswer' => 'required'
        ], [
            'newPin.required' => 'Please enter a new pin.',
            'newPin.digits' => 'Pin must be 4 digits.',
            'selectedSecurityQuestion.required' => 'Please select a security question.',
            'securityAnswer.required' => 'Please provide an answer for the security question.'
        ]);

        LockPin::create([
            'pin' => $this->newPin,
            'security_question' => $this->selectedSecurityQuestion,
            'security_answer' => $this->securityAnswer
        ]);

        redirect()->route('lock-screen');
    }

    public function unlockUsingPin(): void
    {
        $this->validate([
            'unlockPin' => 'required|digits:4'
        ], [
            'unlockPin.required' => 'Please enter your pin.',
            'unlockPin.digits' => 'Pin must be 4 digits.'
        ]);

        $lockPin = LockPin::first();
        if ($lockPin && $lockPin->pin === $this->unlockPin) {
            redirect()->route('home-screen');
        } else {
            $this->addError('unlockPin', 'Invalid pin. Please try again.');
        }
    }

    /**
     * Reset the stored pin using the security answer.
     */
    public function resetPinUsingSecurityAnswer(): void
    {
        $this->validate([
            'forgotAnswer' => 'required',
            'resetPin' => 'required|digits:4',
        ], [
            'forgotAnswer.required' => 'Please provide the security answer.',
            'resetPin.required' => 'Please enter a new pin.',
            'resetPin.digits' => 'Pin must be 4 digits.',
        ]);

        $lockPin = LockPin::first();
        if (!$lockPin) {
            $this->addError('forgotAnswer', 'No pin record found.');
            return;
        }

        if (trim(strtolower($lockPin->security_answer)) === trim(strtolower($this->forgotAnswer))) {
            $lockPin->pin = $this->resetPin;
            $lockPin->save();

            // After reset, redirect back to lock-screen so user can unlock with new pin
            redirect()->route('lock-screen');
        } else {
            $this->addError('forgotAnswer', 'Incorrect answer. Please try again.');
        }
    }
};
?>

<div class="container mx-auto overflow-hidden">
    <div class="w-full h-screen flex justify-center items-center">
        @if(!$firstTime)
            <div class="flex flex-col gap-5">
                <flux:modal.trigger name="unlock-pin">
                    <flux:button icon="text-cursor">Unlock using pin</flux:button>
                </flux:modal.trigger>
                <flux:separator text="OR"/>
                <flux:button icon="finger-print" wire:click="openBiometric">Unlock using Biometric / Face ID</flux:button>
            </div>
        @else
            <flux:callout class="w-full text-center">
                <flux:callout.heading>Welcome to password manager</flux:callout.heading>
                <flux:separator/>
                <flux:callout.text>Please set your pin & also select your security Question & Answer for future pin update.</flux:callout.text>

                <div class="flex flex-col justify-center items-center gap-5 mt-4">
                    <flux:field>
                        <flux:label>New pin</flux:label>
                        <flux:otp length="4" wire:model="newPin"/>
                        <flux:error name="newPin"/>
                    </flux:field>

                    <flux:field>
                        <flux:label>Security question</flux:label>
                        <flux:select wire:model="selectedSecurityQuestion" placeholder="Choose security question...">
                            @foreach($this->securityQuestions as $key => $question)
                                <flux:select.option :value="$question" wire:key="{{ $key }}">{{ $question }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="selectedSecurityQuestion"/>
                    </flux:field>

                    <flux:field>
                        <flux:label>Security answer</flux:label>
                        <flux:input wire:model="securityAnswer"/>
                        <flux:error name="securityAnswer"/>
                    </flux:field>

                    <flux:button variant="primary" color="green" icon="save" wire:click="setNewPin">Save</flux:button>
                </div>
            </flux:callout>
        @endif
    </div>
    <flux:modal name="unlock-pin" class="md:w-96">
        <div class="space-y-6 flex flex-col justify-center items-center text-center">
            <flux:heading>Unlock using pin</flux:heading>
            <flux:separator/>
            <flux:text>Please enter your 4 digit pin to unlock the app.</flux:text>

            <flux:field>
                <flux:label>Enter pin</flux:label>
                <flux:otp length="4" wire:model="unlockPin"/>
                <flux:error name="unlockPin"/>
            </flux:field>

            <flux:button variant="primary" color="green" icon="key-round" wire:click="unlockUsingPin">Unlock</flux:button>

            <flux:modal.trigger name="forgot-pin">
                <flux:link @class(['text-red-800'])>Forgot pin</flux:link>
            </flux:modal.trigger>
        </div>
    </flux:modal>

    <flux:modal name="forgot-pin" class="md:w-96">
        <div class="space-y-6 flex flex-col justify-center items-center text-center">
            <flux:heading>Reset pin</flux:heading>
            <flux:separator/>
            <flux:text>Answer your security question to reset your pin.</flux:text>

            <flux:field>
                <flux:label>Security question</flux:label>
                <flux:text class="font-semibold">{{ $this->lockPin?->security_question ?? 'No security question found' }}</flux:text>
            </flux:field>

            <flux:field>
                <flux:label>Answer</flux:label>
                <flux:input wire:model="forgotAnswer"/>
                <flux:error name="forgotAnswer"/>
            </flux:field>

            <flux:field>
                <flux:label>New PIN</flux:label>
                <flux:otp length="4" wire:model="resetPin"/>
                <flux:error name="resetPin"/>
            </flux:field>

            <flux:button variant="primary" color="green" icon="refresh-ccw" wire:click="resetPinUsingSecurityAnswer">Reset Pin</flux:button>
        </div>
    </flux:modal>
</div>

