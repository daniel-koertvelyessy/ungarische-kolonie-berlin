<?php

namespace App\Livewire\Traits;

use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait HasPrivileges
{
    use AuthorizesRequests;

    protected function checkPrivilege(string|Model $resource): bool
    {
        try {
            $this->authorize('create', $resource);

            return true;
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'Sie haben keine Berechtigungen zur Erstellung von '.(is_string($resource) ? $resource : get_class($resource)).'. => '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return false; // Prevent further execution
        }
    }
}
