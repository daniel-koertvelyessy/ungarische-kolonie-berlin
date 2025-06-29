<?php

declare(strict_types=1);

namespace App\Rules;

use App\Enums\Locale;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueJsonSlug implements ValidationRule
{
    protected string $table;

    protected string $column;

    protected string $locale;

    protected ?int $ignoreId;

    public function __construct(string $table, string $column, ?int $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        //        $this->locale = $lang;
        $this->ignoreId = $ignoreId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract only the locale key from attribute (e.g., "title.de" -> "de")
        //        $locale = last(explode('.', $attribute));

        foreach (Locale::cases() as $locale) {
            $exists = DB::table($this->table)
                ->whereRaw("
            EXISTS (
                SELECT 1 FROM json_each({$this->table}.{$this->column})
                WHERE json_each.key = ? AND json_each.value = ?
            )
        ", [$locale->value, $value])
                ->when($this->ignoreId, fn ($query) => $query->where('id', '!=', $this->ignoreId))
                ->exists();

            if ($exists) {
                $fail("The :attribute must be unique for the {$locale->value} locale.");
            }

        }

    }
}
