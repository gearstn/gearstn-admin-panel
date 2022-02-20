<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Emails</label>
            <select class="select2 justify-content-xl-center" id="emailSelect" name="emails[]" multiple="multiple"
                    data-placeholder="Select category" style="width: 100%;">
                @foreach($emails as $email)
                    <option data-select2-id="{{$email}}">{{ $email }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Categories</label>
            <select class="select2 justify-content-xl-center" id="categorySelect" name="categories[]"
                    multiple="multiple" data-placeholder="Select category" style="width: 100%;">
                @foreach($categories as $category)
                    <option class="categoryOption" onclick="selectEmails($(this))"
                            data-select2-id="{{$category}}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

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
</div><div class="row">
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

<script>
    $(document).ready(function () {
        $('#categorySelect').on('select2:select', function (e) {
            var name = e.params.data.id;
            $.ajax({
                data: {"_token": "{{csrf_token()}}", name},
                type: 'GET',
                url: '{{route("fetch-emails")}}',
                success: function (data) {
                    if (data !== []) {
                        var emails = $('#emailSelect').val();
                        for (var i = 0; i < data.length; i++) {
                            emails.push(data[i])
                        }
                        $('#emailSelect').val(emails).trigger('change')
                    }
                }
            });
        });
    });

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            multiple: true,
            allowClear: true,
            tags: true,
        })
    })
</script>
