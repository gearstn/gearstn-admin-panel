<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('company_name','Company Name')}}
            {{form::text('company_name', $account_manager->company_name ,['class'=>'form-control','placeholder'=>'Company Name'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('first_name','First Name')}}
            {{form::text('first_name', $account_manager->first_name ,['class'=>'form-control','placeholder'=>'First Name'])}}
        </div>
    </div>
    <div class="col-sm-4">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('last_name','Last Name')}}
            {{form::text('last_name', $account_manager->last_name ,['class'=>'form-control','placeholder'=>'last Name'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('email','Email')}}
            {{form::text('email', $account_manager->email ,['class'=>'form-control','placeholder'=>'Email'])}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ form::label('reason','Reason')}}
            {{form::text('reason', $account_manager->reason ,['class'=>'form-control','placeholder'=>'Reason'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('assigned_to_id','Account Manager')}}
            {{ form::select('assigned_to_id', $account_managers , $account_manager->assigned_to_id,['class'=>'select2 form-control', 'id' =>'seller_select', "style"=>"height: 100px"]) }}
        </div>
    </div>
</div>