<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title','English Title')}}
            {{form::text('title_en', $news->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title','English Arabic')}}
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
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('mins_read','Mins Read')}}
            {{form::text('mins_read', $news->mins_read ,['class'=>'form-control','placeholder'=>'Mins Read'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('author_en','Author EN')}}
            {{form::text('author_en', $news->author_en ,['class'=>'form-control','placeholder'=>'Author EN'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('author_ar','Author AR')}}
            {{form::text('author_ar', $news->author_ar ,['class'=>'form-control','placeholder'=>'Author AR'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_title_en','SEO Title EN')}}
            {{form::text('seo_title_en', $news->seo_title_en ,['class'=>'form-control','placeholder'=>'SEO Title EN'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_title_ar','SEO Title AR')}}
            {{form::text('seo_title_ar', $news->seo_title_ar ,['class'=>'form-control','placeholder'=>'SEO Title AR'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_description_en','SEO Description EN')}}
            {{form::text('seo_description_en', $news->seo_description_en ,['class'=>'form-control','placeholder'=>'SEO Description EN'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_description_ar','SEO Description AR')}}
            {{form::text('seo_description_ar', $news->seo_description_ar ,['class'=>'form-control','placeholder'=>'SEO Description AR'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text EN')}}
            {{-- {{form::textarea('bodytext_en',$news->bodytext_en,['class'=>'ckeditor form-control','style'=>'width: 100%'])}} --}}
            {{form::textarea('bodytext_en',$news->bodytext_en,['class'=>'summernote form-control','style'=>'width: 100%'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text AR')}}
            {{-- {{form::textarea('bodytext_ar',$news->bodytext_ar,['class'=>'ckeditor form-control','style'=>'width: 100%'])}} --}}
            {{form::textarea('bodytext_ar',$news->bodytext_ar,['class'=>'summernote form-control','style'=>'width: 100%'])}}
        </div>
    </div>
</div>

{{-- <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'bodytext_en', {
        filebrowserUploadUrl: "{{route('uploads.local_storage', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace( 'bodytext_ar', {
        filebrowserUploadUrl: "{{route('uploads.local_storage', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script> --}}

<script>
    $(function () {
      // Summernote
      $('.summernote').summernote()
    })
</script>
