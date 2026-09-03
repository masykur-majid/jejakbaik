<?php

use Livewire\Component;

new class extends Component
{
    
};
?>

<div class="flex items-center justify-center min-h-screen mx-auto px-4">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Lihat Poin Saya</flux:heading>
        </div>

        <div class="space-y-6">
          

            <flux:field>
                <flux:input type="number" label="Nomor Induk Siswa Nasional (NISN)" placeholder="Masukan NISN" />

                <flux:error name="nisn" />
            </flux:field>
        </div>

        <div class="space-y-2">
            <flux:button variant="primary" color="yellow" class="w-full">Log in</flux:button>
        </div>
    </flux:card>
</div>