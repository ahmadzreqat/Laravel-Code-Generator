

@if(Session::has('error'))
    <div id="error" class="row mr-2 ml-2">
        <button class="btn btn-lg btn-block btn-outline-danger mb-2"
                id="type-error">
            {{ Session::get('error') }}
            <span id="close"
                  class="float-right close text-black-50 hover">&times;</span>
        </button>
    </div>
    <script>
        $('#close').on('click', function () {
            $('#type-error').hide();
        })
    </script>
@endif
