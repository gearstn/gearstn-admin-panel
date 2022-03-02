<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Emails</label>
            <select class="select2 justify-content-xl-center  js-example-basic-multiple js-states form-control" id="receiversSelect" name="receivers[]" multiple="multiple"
                    data-placeholder="Select Email" style="width: 100%;">
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

<div id="overlayer" style="display: none"></div>
<div class="preloader" style="display: none">
    <div class="loader">
        <span class="loader-inner"></span>
    </div>
    <p> Loading...</p>
</div>
<style>
    #overlayer {
        width:100%;
        height:100%;
        position:fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        background:#ffffff;
        opacity: 0.5;
    }
    .preloader p{
        position: absolute;
        top: 80%;
        left: 50%;
        margin-left: -45px;
        width: 120px;
        height: 90px;

        text-align: center;
        color: black;
        font-size: 24px;
        z-index: 3;
    }
    .loader {
        display: inline-block;
        width: 30px;
        height: 30px;
        position: absolute;
        z-index:3;
        border: 4px solid black;
        top: 50%;
        animation: loader 2s infinite ease;
    }
    .loader-inner {
        vertical-align: top;
        display: inline-block;
        width: 100%;
        background-color: black;
        animation: loader-inner 2s infinite ease-in;
    }
    @keyframes loader {
        0% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(180deg);
        }
        50% {
            transform: rotate(180deg);
        }
        75% {
            transform: rotate(360deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    @-webkit-keyframes loader {
        0% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(180deg);
        }
        50% {
            transform: rotate(180deg);
        }
        75% {
            transform: rotate(360deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    @keyframes loader-inner {
        0% {
            height: 0%;
        }
        25% {
            height: 0%;
        }
        50% {
            height: 100%;
        }
        75% {
            height: 100%;
        }
        100% {
            height: 0%;
        }
    }
    @-webkit-keyframes loader-inner {
        0% {
            height: 0%;
        }
        25% {
            height: 0%;
        }
        50% {
            height: 100%;
        }
        75% {
            height: 100%;
        }
        100% {
            height: 0%;
        }
    }
</style>

<script>
    $(document).ready(function () {
        $('#categorySelect').on('select2:select', function (e) {
            var name = e.params.data.id;
            $.ajax({
                data: {"_token": "{{csrf_token()}}", name},
                type: 'GET',
                url: '{{route("fetch-emails")}}',
                beforeSend: function(){
                    $(".preloader").show();
                    $("#overlayer").show();
                },
                success: function (data) {
                    if (data !== []) {
                        var emails = $('#receiversSelect').val();
                        for (var i = 0; i < data.length; i++) {
                            emails.push(data[i])
                        }
                        $('#receiversSelect').val(emails).trigger('change')
                    }
                },
                complete: function(){
                    $(".preloader").hide();
                    $("#overlayer").hide();
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
<style>
    .select2-container .select2-selection {
        height: 100%;
        overflow: scroll;
    }
</style>
