<div>

        <flux:radio.group variant="segmented"
                          size="sm"
        >
            <flux:radio
                wire:click="switchLanguage('de')"
                :checked="$currentLocale === 'de'"
                label="de"
            />
            <flux:radio
                wire:click="switchLanguage('hu')"
                :checked="$currentLocale === 'hu'"
                label="hu"
            > />
            </flux:radio.group>
        </flux:menu.item>

{{--        <flux:menu.item icon="language">    </flux:menu.item>--}}

    {{--    <flux:dropdown>
        <flux:menu.item icon="language">
            <span>{{ strtoupper($currentLocale) }}</span>
        </flux:menu.item>

            <flux:navmenu>
                <flux:navmenu.item wire:click="switchLanguage('en')" :disabled="$currentLocale === 'en'">
                    🇬🇧 English
                </flux:navmenu.item>
                <flux:navmenu.item wire:click="switchLanguage('de')" :disabled="$currentLocale === 'de'">
                    🇩🇪 Deutsch
                </flux:navmenu.item>
                <flux:navmenu.item wire:click="switchLanguage('hu')" :disabled="$currentLocale === 'hu'">
                    🇭🇺 Magyar
                </flux:navmenu.item>
            </flux:navmenu.content>
        </flux:dropdown>--}}
</div>
