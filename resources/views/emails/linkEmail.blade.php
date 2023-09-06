<div>

    <h2>Hello!!</h2>
    <p>I hope this email finds you well.</p> {{ $id }}
    @foreach ($prices as $item)
        <br>
        {{ $item->name }} ===== {{ $item->current_rate }}
    @endforeach
    <p>If there are any changes to these rates... please follow the below link to update otherwise Ignore it</p>
    <a href="{{ env('APP_URL') }}update/prices/{{ $id }}">Click Me</a>

</div>
