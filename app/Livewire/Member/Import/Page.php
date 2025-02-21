<?php

namespace App\Livewire\Member\Import;

use App\Models\Membership\Member;
use Livewire\Component;
use Livewire\WithFileUploads;

class Page extends Component
{
    use WithFileUploads;

    public $jsonFile;

    public $jsonText;

    public array $parsedUsers = [];

    protected $rules = [
        'jsonText' => 'nullable|string',
        'jsonFile' => 'nullable|file|mimes:json|max:1024',
        'parsedUsers.*.name' => 'required|string|max:255',
        'parsedUsers.*.first_name' => 'required|string|max:255',
        'parsedUsers.*.email' => 'nullable|email|max:255',
    ];

    public function updatedJsonFile()
    {
        $this->validateOnly('jsonFile');

        $path = $this->jsonFile->getRealPath();
        $content = file_get_contents($path);
        $this->parseJson($content);
    }

    public function updatedJsonText()
    {
        $this->parseJson($this->jsonText);
    }

    private function parseJson($json)
    {
        try {
            $data = json_decode($json, true);

            if (! is_array($data)) {
                throw new \Exception('Invalid JSON format.');
            }

            // Validate structure and populate $parsedUsers
            $this->parsedUsers = collect($data)
                ->map(function ($item) {
                    if (! isset($item['name'], $item['first_name'], $item['email'])) {
                        throw new \Exception('Invalid JSON structure.');
                    }

                    return [
                        'name' => $item['name'],
                        'first_name' => $item['first_name'],
                        'email' => $item['email'],
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            $this->addError('jsonText', 'Invalid JSON: '.$e->getMessage());
            $this->parsedUsers = [];
        }
    }

    public function import()
    {
        $this->validate();

        if (empty($this->parsedUsers)) {
            $this->addError('jsonText', 'No valid data to import.');

            return;
        }

        foreach ($this->parsedUsers as $user) {
            Member::updateOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'first_name' => $user['first_name']]
            );
        }

        // Cleanup
        $this->reset(['jsonFile', 'jsonText', 'parsedUsers']);
        session()->flash('success', 'Users imported successfully!');
    }

    public function render()
    {
        return view('livewire.member.import.page');
    }
}
