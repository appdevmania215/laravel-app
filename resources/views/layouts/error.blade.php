@if($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        alert('{{ $error }}')
        @endforeach
    </script>
@endif
