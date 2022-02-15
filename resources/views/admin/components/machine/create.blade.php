@extends("admin.layouts.index")
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Machine</h3>
                        </div>
                        <div class="card-body">
                            {!! form::open(['route'=>['machines.store',$machine],'id'=>'form-data'] ) !!}
                            @method('POST')
                            {{csrf_field()}}
                            @include('admin.components.machine.fields')
                            <input type="hidden" id="photos" name="photos" value="{{ $machine->images }}">
                            {!!form::close()!!}
                            @include('admin.widgets.uploader.dragdrop' , $attr = ['route' => 'create'] )
                            <br>
                            <button type="submit" class="btn btn-block btn-success" onclick="$('#form-data').submit()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


