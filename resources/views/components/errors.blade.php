<ul class="text-danger">
    @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>
