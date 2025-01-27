@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<x-application-logo class="size-12" />
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
