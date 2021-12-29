<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('first_name','First Name')}}
            {{form::text('first_name', $user->first_name ,['class'=>'form-control','placeholder'=>'First Name'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('last_name','Last Name')}}
            {{form::text('last_name', $user->last_name ,['class'=>'form-control','placeholder'=>'Last Name'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('company_name','Company Name')}}
            {{form::text('company_name', $user->company_name ,['class'=>'form-control','placeholder'=>'Company Name'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('country','Country')}}
            {{form::text('country', $user->country ,['class'=>'form-control','placeholder'=>'Country'])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('tax_license','Tax License')}}
            {{form::text('tax_license', $user->tax_license ,['class'=>'form-control','placeholder'=>'Tax License'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('commercial_license','Commercial License')}}
            {{form::text('commercial_license', $user->commercial_license ,['class'=>'form-control','placeholder'=>'Commercial License'])}}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {{ form::label('email','Email')}}
            {{form::text('email', $user->email ,['class'=>'form-control','placeholder'=>'Email'])}}
        </div>
    </div>
    <div class="col-sm-3">
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
