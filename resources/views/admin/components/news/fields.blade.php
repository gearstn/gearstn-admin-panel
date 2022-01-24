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
            {{ form::label('author','Author')}}
            {{form::text('author', $news->author ,['class'=>'form-control','placeholder'=>'Author'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('mins_read','Mins Read')}}
            {{form::text('mins_read', $news->mins_read ,['class'=>'form-control','placeholder'=>'Mins Read'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_title','SEO Title')}}
            {{form::text('seo_title', $news->seo_title ,['class'=>'form-control','placeholder'=>'SEO Title'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('seo_description','SEO Description')}}
            {{form::text('seo_description', $news->seo_description ,['class'=>'form-control','placeholder'=>'SEO Description'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text EN')}}
            {{form::textarea('bodytext_en',$news->bodytext_en,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('bodytext','Body Text AR')}}
            {{form::textarea('bodytext_ar',$news->bodytext_ar,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
        </div>
    </div>
</div>
