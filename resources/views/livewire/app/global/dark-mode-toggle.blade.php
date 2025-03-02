<div>
    <flux:button.group>
        <flux:button size="sm" wire:click="setTheme('light')" :class="$theme === 'light' ? 'bg-blue-500 text-white' : 'bg-gray-200'">
            <flux:icon.sun class="w-3 h-3" />
        </flux:button>

        <flux:button size="sm" wire:click="setTheme('dark')" :class="$theme === 'dark' ? 'bg-blue-500 text-white' : 'bg-gray-200'">
            <flux:icon.moon class="w-3 h-3" />
        </flux:button>

        <flux:button size="sm" wire:click="setTheme('system')" :class="$theme === 'system' ? 'bg-blue-500 text-white' : 'bg-gray-200'">
            <flux:icon.computer-desktop class="w-3 h-3" />
        </flux:button>
    </flux:button.group>

    @script
    <script>
        document.addEventListener('alpine:init', () => {
            console.log("Changing theme to:", theme);
            console.log("Document element:", document.documentElement);
            window.applyTheme = function (theme) {
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                localStorage.setItem('theme', theme);
            };

            Livewire.on('theme-changed', (theme) => {
                applyTheme(theme);
            });

            // Ensure theme is applied correctly when the component loads
            document.addEventListener('DOMContentLoaded', () => {
                applyTheme(localStorage.getItem('theme') || 'system');
            });
        });
    </script>
    @endscript
</div>
