<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('title_en','English Title')}}
            {{form::text('title_en', $employee->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('title_ar','Arabic Title')}}
            {{form::text('title_ar', $employee->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('name_en','English Name')}}
            {{form::text('name_en', $employee->name_en ,['class'=>'form-control','placeholder'=>'English Name'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('name_ar','Arabic Name')}}
            {{form::text('name_ar', $employee->name_ar ,['class'=>'form-control','placeholder'=>'Arabic Name'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('image','Image URL')}}
            {{form::text('image_url', $employee->image_url ,['class'=>'form-control','placeholder'=>'Image URL'])}}
        </div>
    </div>
</div>
