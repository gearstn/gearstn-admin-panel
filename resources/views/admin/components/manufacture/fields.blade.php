<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title_en','English Title')}}
            {{form::text('title_en', $manufacture->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('title_ar','Arabic Title')}}
            {{form::text('title_ar', $manufacture->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('categories','Categories')}}
            {{ form::select('category_id', $categories, $manufacture->category_id,['class'=>'select2 form-control templatingSelect2', "style"=>"height: 100px"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('sub_categories','SubCategories')}}
            {{Form::select('sub_categories',$sub_categories,$manufacture->sub_categories()->pluck('id')->toArray(),['multiple'=>'multiple','name'=>'sub_categories[]' ,'class'=>'select2 form-control templatingSelect2', "style"=>"height: 100px"])}}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.templatingSelect2').select2({
            theme: "bootstrap4",
        });
    });
</script>

