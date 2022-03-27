<a class="waves-effect btn btn-xs btn-primary edit-btn" data-value="$data->id"
    href="{{ route("{$page}.edit", $data->id) }}">Update</a>
<form action="{{ route("{$page}.destroy", $data->id) }}" method="POST" onsubmit="return confirm('Are you sure?')"
    style="display: inline-block;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
</form>

@if ($page === 'machines')
    <button type="button" class="waves-effect btn btn-xs btn-light approve-{{ $data->id }} "
        value="{{ $data->id }}">
        Approve
    </button>
    {{-- <button type="button" class="waves-effect btn btn-xs btn-light feature-{{$data->id}} "  value="{{$data->id}}">
        Feature
    </button>
    <button type="button" class="waves-effect btn btn-xs btn-light verify-{{$data->id}} "  value="{{$data->id}}">
        Verify
    </button> --}}
@endif


@if ($page === 'users')
    <form action="{{ route("{$page}.show", $data) }}" method="GET" style="display: inline-block;">
        <button type="submit" class="waves-effect btn btn-xs btn-light profile-{{ $data->id }} "
            value="{{ $data->id }}">
            Show Profile
        </button>
    </form>
@endif

<script>
    $('#datatable_wrapper tbody tr').on('click', '.approve-{{ $data->id }}', function() {
        var id = $(this).val();
        var c = confirm('Are you sure?');
        if (c) {
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{!! route('machines.approve', ['id' => $data->id]) !!}",
                success: function() {
                    $("#datatable").DataTable().ajax.reload()
                    var message = $('' +
                        '<div class="alert alert-success m-1" id ="success-message" style="margin:15px; height:2.5rem"  role="alert"> <p class="justify-content-center mb-3">{{ ucfirst($page) }} Approved/UnApproved succesfully</p> <br>' +
                        '</div>');
                    $(".content").prepend(message);
                    $('#success-message').fadeOut(8000, function() {
                        $(this).remove();
                    })
                }
            });

        }
    })

    $('#datatable_wrapper tbody tr').on('click', '.feature-{{ $data->id }}', function() {
        var id = $(this).val();
        var c = confirm('Are you sure?');
        if (c) {
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{!! route('machines.feature', ['id' => $data->id]) !!}",
                success: function() {
                    $("#datatable").DataTable().ajax.reload()
                    var message = $('' +
                        '<div class="alert alert-success m-1" id ="success-message" style="margin:15px; height:2.5rem"  role="alert"> <p class="justify-content-center mb-3">{{ ucfirst($page) }} Featured/UnFeatured succesfully</p> <br>' +
                        '</div>');
                    $(".content").prepend(message);
                    $('#success-message').fadeOut(8000, function() {
                        $(this).remove();
                    })
                }
            });

        }
    })

    $('#datatable_wrapper tbody tr').on('click', '.verify-{{ $data->id }}', function() {
        var id = $(this).val();
        var c = confirm('Are you sure?');
        if (c) {
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{!! route('machines.verify', ['id' => $data->id]) !!}",
                success: function() {
                    $("#datatable").DataTable().ajax.reload()
                    var message = $('' +
                        '<div class="alert alert-success m-1" id ="success-message" style="margin:15px; height:2.5rem"  role="alert"> <p class="justify-content-center mb-3">{{ ucfirst($page) }} Verified/UnVerified succesfully</p> <br>' +
                        '</div>');
                    $(".content").prepend(message);
                    $('#success-message').fadeOut(8000, function() {
                        $(this).remove();
                    })
                }
            });

        }
    })
</script>
