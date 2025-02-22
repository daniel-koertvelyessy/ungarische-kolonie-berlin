<?php

namespace App\Livewire\Traits;

use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait HasPrivileges
{
    use AuthorizesRequests;

    protected function checkPrivilege(string|Model $resource): void
    {
        try {
            $this->authorize('create', $resource);
        } catch (AuthorizationException $e) {
            $resourceName = is_string($resource) ? $resource : get_class($resource);

            Flux::toast(
                text: 'Sie haben keine Berechtigungen zur Erstellung von '.$resourceName.'. => '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }
    }
}
