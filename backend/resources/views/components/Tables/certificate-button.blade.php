@props(['certification'])

@if($certification)
    <a href="{{ asset('storage/' . $certification) }}" 
       target="_blank"
       class="text-blue-600 hover:underline">
        View Certificate
    </a>
@else
    <span class="text-gray-400 italic">No Certificate</span>
@endif
