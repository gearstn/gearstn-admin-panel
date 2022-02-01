<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('year','Year')}}
            {{form::text('year', $machine->year ,['class'=>'form-control','placeholder'=>'Year'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('sn','SN')}}
            {{form::text('sn', $machine->sn ,['class'=>'form-control','placeholder'=>'SN'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('condition','Condition')}}
            {{form::text('condition', $machine->condition ,['class'=>'form-control','placeholder'=>'Condition'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('hours','Hours')}}
            {{form::text('hours', $machine->hours ,['class'=>'form-control','placeholder'=>'Hours'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('sell_type','Sell Type')}}
            {{form::text('sell_type', $machine->sell_type ,['class'=>'form-control','placeholder'=>'Sell Type'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('rent_hours','Rent Hours')}}
            {{form::text('rent_hours', $machine->rent_hours ,['class'=>'form-control','placeholder'=>'Rent Hours'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('country','Country')}}
            {{form::text('country', $machine->country ,['class'=>'form-control','placeholder'=>'Country'])}}
        </div>
    </div>
    {{-- <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('images','Images Link')}}
            {{form::text('images', $machine->images ,['class'=>'form-control','placeholder'=>'Images Link'])}}
        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('approved','Approved')}}
            {{form::text('approved', $machine->approved ,['class'=>'form-control','placeholder'=>'Approved'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('featured','Featured')}}
            {{form::text('featured', $machine->featured ,['class'=>'form-control','placeholder'=>'Featured'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('verified','Verified')}}
            {{form::text('verified', $machine->verified ,['class'=>'form-control','placeholder'=>'Verified'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('price','Price')}}
            {{form::text('price', $machine->price ,['class'=>'form-control','placeholder'=>'Price'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('category','Categories')}}
            {{ form::select('category_id', $categories, $machine->category_id,['class'=>'select2 form-control', 'id' =>'category_select', "style"=>"height: 100px"]) }}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('sub_category','SubCategories')}}
            {{ form::select('sub_category_id', $sub_categories , $machine->sub_category_id,['class'=>'select2 form-control', 'id' =>'sub_category_select', "style"=>"height: 100px",'disabled']) }}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('manufacture','Manufactures')}}
            {{ form::select('manufacture_id', $manufactures, $machine->manufacture_id,['class'=>'select2 form-control', 'id' =>'manufacture_select', "style"=>"height: 100px"]) }}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('model','Models')}}
            {{ form::select('model_id', $models , $machine->model_id,['class'=>'select2 form-control', 'id' =>'model_select', "style"=>"height: 100px",'disabled']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('city','Cities')}}
            {{ form::select('city_id', $cities , $machine->city_id,['class'=>'select2 form-control', 'id' =>'city_select', "style"=>"height: 100px"]) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('seller','Sellers')}}
            {{ form::select('seller_id', $sellers , $machine->seller_id,['class'=>'select2 form-control', 'id' =>'seller_select', "style"=>"height: 100px"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('description','Description')}}
            {{form::textarea('description', $machine->description ,['class'=>'form-control','placeholder'=>'Description'])}}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.templatingSelect2').select2({
            theme: "bootstrap4",
        });
        $('.select2').select2({
            theme: 'bootstrap4',
            allowClear: true,
            tags: true,
        })

        $('#category_select').on('select2:select', function (e) {
            var id = e.params.data.id;
            $.ajax({
                data: {"_token": "{{csrf_token()}}", id},
                type: 'GET',
                url: '{{route("fetchSubCategories")}}',
                success: function (data) {
                    if (data !== []) {
                        $("#sub_category_select").prop('disabled', false)
                        $('#sub_category_select').find('option').remove().end();
                        for (const [key, value] of Object.entries(data)) { $("#sub_category_select").append(new Option(value, key)); }
                    }
                }
            });
        });

        $('#manufacture_select').on('select2:select', function (e) {
            var id = e.params.data.id;
            $.ajax({
                data: {"_token": "{{csrf_token()}}", id},
                type: 'GET',
                url: '{{route("fetchMachineModels")}}',
                success: function (data) {
                    if (data !== []) {
                        $("#model_select").prop('disabled', false)
                        $('#model_select').find('option').remove().end();
                        for (const [key, value] of Object.entries(data)) { $("#model_select").append(new Option(value, key)); }
                    }
                }
            });
        });

    });
</script>

