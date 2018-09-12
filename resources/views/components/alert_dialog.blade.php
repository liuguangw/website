<div
    class="alert-dialog animated faster pulse"
    @if($alertId!='')
    id="{{ $alertId }}"
    @endif
>
    <div class="alert {{ $alertClass }}" role="alert">
        {{ $slot }}
        @if($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @elseif(!empty($success))
            {{ $success }}
        @endif
    </div>
</div>
