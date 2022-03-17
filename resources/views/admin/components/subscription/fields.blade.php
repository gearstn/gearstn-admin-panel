<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title_en','English Title')}}
            {{form::text('title_en', $subscription->title_en ,['class'=>'form-control','placeholder'=>'English Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('title_ar','Arabic Title')}}
            {{form::text('title_ar', $subscription->title_ar ,['class'=>'form-control','placeholder'=>'Arabic Title'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('user_type','User Type')}}
            {{ form::select('role_id', $roles, $subscription->roles,['class'=>'select2 form-control', 'id' =>'user_type_select']) }}
        </div>
    </div>
</div>


@if(Route::current()->getName() == 'subscriptions.edit')
    <div class="container-fluid p-0">
        <div class="input_fields_wrap">
            <button class="add_field_button btn btn-success">Add Fields For Subscription Details</button>
            @php $i = 0 @endphp
            @foreach ($subscription->details as  $key => $value )
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ form::label('key','Key')}}
                            <input type="text" class="form-control" name="details[{{$i}}][key]" value=" {{$key}} "/> 
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ form::label('value','Value')}}
                            <input type="text" class="form-control" name="details[{{$i}}][value]" value=" {{$value}} "/> 
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ form::label(' ',' ')}}
                            <a href="#" class="remove_field btn btn-danger form-control mt-2">Remove</a>
                        </div>
                    </div>
                </div>
            @php $i++ @endphp
            @endforeach
        </div>
    </div>
@else
    <div class="input_fields_wrap">
        <button class="add_field_button btn btn-success">Add Fields For Subscription Details</button>
    </div>
@endif

<script>
    $(document).ready(function() {
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = {{ count($subscription->details) }}; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
        // $(wrapper).append('<div><input type="text" name="details['+x+'][key]"/> <input type="text" name="details['+x+'][value]"/> <a href="#" class="remove_field">Remove</a></div>'); //add input box
        $(wrapper).append('<div class="row">'+
                '<div class="col-sm-4">'+
                    '<div class="form-group">'+
                        '<label>Key</label>'+
                        '<input type="text" class="form-control" name="details['+x+'][key]" />'+
                    '</div>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<div class="form-group">'+
                        '<label>Value</label>'+
                        '<input type="text" class="form-control" name="details['+x+'][value]" /> '+
                    '</div>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<div class="form-group">'+
                        '<label>  </label>'+
                        '<a href="#" class="remove_field btn btn-danger form-control mt-2">Remove</a>'+
                    '</div>'+
                '</div>'+
            '</div>'); //add input box
        x++; //text box increment
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove();
	})
});
</script>