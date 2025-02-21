<?php

namespace App\Livewire\Forms;

use App\Models\Venue;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VenueForm extends Form
{
    public Venue $venue;

    #[validate]
    public string $name = '';

    #[validate]
    public string $address = '';

    public string $city = '';

    public string $country = '';

    public string $postal_code = '';

    public string $phone = '';

    public string $website = '';

    public string $geolocation = '';

    public function setVenue(Venue $venue): void
    {
        $this->venue = $venue;

        $this->name = $this->venue->name;
        $this->address = $this->venue->address;
        $this->city = $this->venue->city;
        $this->country = $this->venue->country;
        $this->postal_code = $this->venue->postal_code;
        $this->phone = $this->venue->phone;
        $this->website = $this->venue->website;
        $this->geolocation = $this->venue->geolocation;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('venues')->ignore($this->name),
            ],
            'address' => ['required', 'string'],
        ];
    }

    public function store(): int
    {
        $this->validate();

        $venue = new Venue;

        $venue->name = $this->name;
        $venue->address = $this->address;
        $venue->city = $this->city;
        $venue->country = $this->country;
        $venue->postal_code = $this->postal_code;
        $venue->phone = $this->phone;
        $venue->website = $this->website;
        $venue->geolocation = $this->geolocation;

        return $venue->save() ? $venue->id : 0;
    }

    public function update()
    {

        $this->validate();

        return $this->venue->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
            'geolocation' => $this->geolocation,
        ]);

    }
}
