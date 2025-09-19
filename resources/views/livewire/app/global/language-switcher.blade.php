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

</div>
