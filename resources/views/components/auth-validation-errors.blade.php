@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-md border border-red-400 bg-red-100 px-4 py-3 text-red-700']) }}>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
