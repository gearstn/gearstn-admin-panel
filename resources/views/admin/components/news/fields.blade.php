<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title','English Title')}}
            {{form::text('title_en', $news->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title','English Title')}}
            {{form::text('title_ar', $news->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('post_date','Post Date')}}
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                {{form::text('post_date', $news->post_date ,['class'=>'form-control float-right','id'=>'reservationdate'])}}
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text EN')}}
            {{form::textarea('bodytext_en',$news->bodytext_en,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
            {{-- <textarea class="ckeditor form-control" value = "{{ $news->bodytext }}" name="bodytext"
                      style="width: 100%"></textarea> --}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text AR')}}
            {{form::textarea('bodytext_ar',$news->bodytext_ar,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
            {{-- <textarea class="ckeditor form-control" value = "{{ $news->bodytext }}" name="bodytext"
                      style="width: 100%"></textarea> --}}
        </div>
    </div>
</div>
