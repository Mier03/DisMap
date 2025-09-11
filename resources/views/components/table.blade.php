@props(['columns', 'rows', 'table_title', 'icon'])

<div class="p-4 bg-white border border-g-dark rounded-lg">
    <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-7 h-7 text-g-dark" />
        @endif
        <span>{{ $table_title }}</span>
    </p>
    <table class="w-full text-left">
        <thead>
            <tr class="text-g-dark border-b">
                @foreach($columns as $column)
                    <th class="p-2">{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr class="border-b">
                    @foreach($row as $data)
                        <td class="p-2">{!! $data !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
