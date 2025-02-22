@if(!app()->isProduction())
    @if ($errors->any())
        <div class="text-orange-800 text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif
