<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('first_name','First Name')}}
            {{form::text('first_name', $user->first_name ,['class'=>'form-control','placeholder'=>'First Name'])}}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('last_name','Last Name')}}
            {{form::text('last_name', $user->last_name ,['class'=>'form-control','placeholder'=>'Last Name'])}}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('company_name','Company Name')}}
            {{form::text('company_name', $user->company_name ,['class'=>'form-control','placeholder'=>'Company Name'])}}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('country','Country')}}
            {{form::text('country', $user->country ,['class'=>'form-control','placeholder'=>'Country'])}}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('email','Email')}}
            {{form::text('email', $user->email ,['class'=>'form-control','placeholder'=>'Email'])}}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {{ form::label('phone','Phone Number')}}
            {{form::text('phone', $user->phone ,['class'=>'form-control','placeholder'=>'Phone Number'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('tax_license','Tax License Number')}}
            {{form::text('tax_license', $user->tax_license ,['class'=>'form-control','placeholder'=>'Tax License Number'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('tax_license_image','Tax License Image')}}
            {{form::file('tax_license_image' ,['class'=>'form-control'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('commercial_license','Commercial License Number')}}
            {{form::text('commercial_license', $user->commercial_license ,['class'=>'form-control','placeholder'=>'Commercial License Number'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('commercial_license_image','Commercial License Image')}}
            {{form::file('commercial_license_image' ,['class'=>'form-control'])}}
        </div>
    </div>


</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('national_id','National ID Number')}}
            {{form::text('national_id', $user->national_id ,['class'=>'form-control','placeholder'=>'National ID Number'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('national_id_image','National ID Image')}} <br>
            {{form::file('national_id_image' ,['class'=>'form-control', 'multiple' => 'true'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('user_type','User Type')}}
            {{ form::select('role_id', $roles, $user->roles ,['class'=>'select2 form-control', 'id' =>'user_type_select']) }}
        </div>
    </div>
</div>

@if(Route::current()->getName() !== 'users.edit')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Password Confirmation">
            </div>
        </div>
    </div>
@endif
