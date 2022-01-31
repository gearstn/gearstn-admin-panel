<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('title_en','English Title')}}
            {{form::text('title_en', $auction->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('title_ar','Arabic Title')}}
            {{form::text('title_ar', $auction->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('country','Country')}}
            {{form::text('country', $auction->country ,['class'=>'form-control','placeholder'=>'Country'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('start_end_date','Start End Date')}}
            <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                {{form::text('reservationtime', $auction->reservationtime ,['class'=>'form-control float-right','id'=>'reservationtime'])}}
            </div>
        </div>
    </div>
</div>
