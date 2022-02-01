@extends("admin.layouts.index")
@section("content")

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Settings</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                {!! form::open(['route'=>['settings.update'],'id'=>'form-data', 'method'=>"post"] ) !!}
                    @csrf

                    <div class="row">
                        @foreach($settings as $setting)
                            <div class="col-sm-6">
                                <div class="form-group p-2">
                                    {{ form::label('title',$setting->message)}}
                                    {{form::textarea($setting->type, $setting->value, ['class'=>'form-control'])}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                {!!form::close()!!}
                <button type="submit" class="btn btn-success float-right m-3" onclick="$('#form-data').submit()">Save
                    Changes
                </button>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('.templatingSelect2').select2({
                theme: "bootstrap4",
            });
        });
    </script>

 
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
@foreach($settings as $setting)
    <script>
        CKEDITOR.replace( '{{$setting->type}}', {
            filebrowserUploadUrl: "{{route('uploads.local_storage', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endforeach
@endsection
