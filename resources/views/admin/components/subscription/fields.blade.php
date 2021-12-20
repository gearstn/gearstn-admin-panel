<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('title_en','English Title')}}
            {{form::text('title_en', $subscription->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('title_ar','Arabic Title')}}
            {{form::text('title_ar', $subscription->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
</div>
