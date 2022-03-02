<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('subject','Subject')}}
            {{form::text('subject',$mail->subject,['class'=>'form-control','placeholder'=>'Subject'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('body_ene','Body EN')}}
            {{form::textarea('body_en',$mail->body_en,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('body_are','Body AR')}}
            {{form::textarea('body_ar',$mail->body_ar,['class'=>'ckeditor form-control','style'=>'width: 100%'])}}
        </div>
    </div>
</div>

<br>

<div>
    <button type="button" class="btn btn-block btn-default mb-2" onclick="$('#datetime').toggle()">Schedule</button>
</div>
<div class="form-group" id="datetime" style="display:none">
    <label>Date and time Schedule Mail:</label>
    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
        <input type="text" name="datetime" class="form-control datetimepicker-input" data-target="#reservationdatetime">
        <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
    <br>
</div>


<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'body_en', {
        filebrowserUploadUrl: "{{route('uploads.local_storage', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace( 'body_ar', {
        filebrowserUploadUrl: "{{route('uploads.local_storage', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
