@extends("admin.layouts.index")
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit</h1>
                </div>
                <div class="col-sm-6">
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
                            <h3 class="card-title">Edit News</h3>
                        </div>
                        <div class="card-body">
                            {!! form::open(['route'=>['news.update',$news],'id'=>'form-data'] ) !!}
                            @method('PATCH')
                            {{csrf_field()}}
                            @include('admin.components.news.fields')

                            <input type="hidden" id="photos" name="photos" value="{{ $news->images }}">
                            {!!form::close()!!}

                            {{-- <label> Upload New Imgaes </label>
                            @include('admin.widgets.uploader.dragdrop' , $attr=['route' => 'edit'] )

                            <label> Stored Images </label>
                            <div class="row mt-3">
                                    <div class="col-sm-3">
                                        <img src="{{ $news->image_id }}"  width="100%" height="100%" style="object-fit: cover">

                                        <form action="{{route("uploads.destroy")}}" method="POST" onsubmit="return confirm('Are you sure?')"
                                            style="display: inline-block;">
                                          @csrf
                                          <input type="hidden" name="_method" value="POST">
                                          <input type="hidden" name="ids" value=" {{ $news->image_id->id }} ">
                                          <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                        </form>
                                    </div>
                            </div>                             --}}
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


