<?php

use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array|Collection $data = [];

    public function mount(): void
    {
        $this->data = \App\Models\Password::GetAllPasswords()
            ->map(fn($d) => $d->toArray())
            ->all();
    }

    #[On('passwordDeleted')]
    public function refreshPage(): void
    {
        $this->mount();
    }
};
?>

<div>
    @forelse($data as $item)
        <livewire:password-card :password="$item" :key="$item->id ?? null"/>
    @empty
        <flux:callout variant="warning" icon="exclamation-circle" heading="Sorry now data found"/>
    @endforelse
</div>