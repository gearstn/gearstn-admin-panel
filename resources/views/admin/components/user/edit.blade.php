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
                            <h3 class="card-title">Edit User</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {!! form::open(['route'=>['users.update',$user],'id'=>'form-data','files' => true] ) !!}
                                @method('PATCH')
                                {{csrf_field()}}
                                @include('admin.components.user.fields')
                                {!!form::close()!!}
                                <button type="submit" class="btn btn-block btn-success" onclick="$('#form-data').submit()">
                                    Submit
                                </button>
                            </div>
                            <div class="row mt-3">
                                <div class="card table-responsive">
                                    <div class="card-header">
                                      <h3 class="card-title">Users Image Table</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body p-0 ">
                                      <table class="table">
                                        <thead>
                                          <tr>
                                            <th style="width: 10%">#</th>
                                            <th style="width: 20%">Image Type</th>
                                            <th style="width: 60%">Image Url</th>
                                            <th style="width: 10%">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($images as $key => $image )
                                                <tr>
                                                    <td>1.</td>
                                                    <td> {{$key}} </td>
                                                    <td>
                                                        <div>
                                                            @if ($image !== null)
                                                                <a href="{{ $image->url }}">{{ $image->url }}</a>
                                                            @else
                                                                No Image Uploaded
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($image !== null)
                                                            <form action="{{route("uploads.user_destroy")}}" method="POST" onsubmit="return confirm('Are you sure?')"
                                                                style="display: inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="POST">
                                                            <input type="hidden" name="id" value=" {{$image->id}} ">
                                                            <input type="hidden" name="key" value=" {{ $key }} ">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                                            </form>
                                                        @else
                                                            No Action
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- <tr>
                                                <td>1.</td>
                                                <td>Tax License Image</td>
                                                <td>
                                                    <div>
                                                            @if ($images['tax_license_image'] !== null)
                                                                <a href="{{ $images['tax_license_image']->url }}">{{ $images['tax_license_image']->url }}</a>
                                                            @else
                                                                No Image Uploaded
                                                            @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="{{route("uploads.destroy", $images['tax_license_image']->id)}}" method="POST" onsubmit="return confirm('Are you sure?')"
                                                        style="display: inline-block;">
                                                      @csrf
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>Commercial License Image</td>
                                                <td>
                                                    <div>
                                                            @if ($images['commercial_license_image'] !== null)
                                                                <a href="{{ $images['commercial_license_image']->url }}">{{ $images['commercial_license_image']->url }}</a>
                                                            @else
                                                                No Image Uploaded
                                                            @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="{{route("uploads.destroy", $images['commercial_license_image']->id)}}" method="POST" onsubmit="return confirm('Are you sure?')"
                                                        style="display: inline-block;">
                                                      @csrf
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>National ID Image</td>
                                                <td>
                                                    <div>
                                                            @if ($images['national_id_image'] !== null)
                                                                <a href="{{ $images['national_id_image']->url }}">{{ $images['national_id_image']->url }}</a>
                                                            @else
                                                                No Image Uploaded
                                                            @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="{{route("uploads.destroy", $images['national_id_image']->id)}}" method="POST" onsubmit="return confirm('Are you sure?')"
                                                        style="display: inline-block;">
                                                      @csrf
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                                    </form>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                      </table>
                                    </div>
                                    <!-- /.card-body -->
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


