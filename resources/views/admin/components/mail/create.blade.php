@extends("admin.layouts.index")
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>Create</h1>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-block btn-primary btn-md" onclick="download()">Download
                        Template
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-header">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! form::open(['route'=>['mails.store',$mail],'id'=>'form-data' , 'enctype'=>"multipart/form-data"] ) !!}
                            @method('POST')
                            {{csrf_field()}}
                            @include('admin.components.mail.emails&categories-fields')
                            @include('admin.components.mail.fields')
                            {!!form::close()!!}
                            <button type="submit" class="btn btn-block btn-success" onclick="$('#form-data').submit()">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


