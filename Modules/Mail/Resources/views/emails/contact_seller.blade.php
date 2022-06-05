<html>
<head>
    <title>GearsTN</title>
</head>
<body>
    <h1>Hello {{ $details['seller']->company_name }}</h1>
    <p> {{ $details['buyer']->company_name }} has send you a message regarding your machine.</p>
    <a href="{{ env('APP_URL'). '/'. $details['machine']->slug }}"> {{ env('APP_URL'). '/'. $details['machine']->slug }} </a>
    <br>
    <p> {{ $details['body'] }}</p>
    <br>
    <p> Here is his email address: {{ $details['buyer']->email }}</p>
    <p> Please, do your best to respond to his message as soon as you can to get the {{ $details['machine']->sel_type }} transaction done.</p>
    <br>
    <p>Thank you</p>
    <br><br><br>


    <h1>{{ $details['seller']->company_name }} مرحبا</h1>
    <p>.سالة إليك بخصوص مكينتك{{ $details['buyer']->company_name }} أرسل</p>
    <a href="{{ env('APP_URL'). '/'. $details['machine']->slug }}"> {{ env('APP_URL'). '/'. $details['machine']->slug }} </a>
    <br>
    <p> {{ $details['body'] }}</p>
    <br>
    <p>{{ $details['buyer']->email }} : و هذا عنوانه بريده الإلكتروني</p>
    <p>.في اسرع وقت  {{ $details['machine']->sel_type }} من فضلك ، ابذل قصارى جهدك للرد على رسالته بمجرد أن تسطيع لتتمكن من إتمام معاملة </p>
    <br>
    <p>شكرا لك</p>
</body>
</html>
