<html>

<head>
    <title>GearsTN</title>
</head>

<body>
    <h1>Hello {{ $details['owner']->company_name }}</h1>
    <p> You have a new conversation</p>
    <br>
    <p>from {{ $details['acquire']->first_name }} {{ $details['acquire']->last_name }}</p>
    <br>

<! --

    <p>about your product {{ $details['model']->slug }}</p>

 -->

    <br>
    <p>Thank you</p>
    <br><br><br>


    <h1>{{ $details['owner']->company_name }} مرحبا</h1>
    <p>لديك محادثة جديدة</p>
    <br>
    <p> {{ $details['acquire']->first_name }} {{ $details['acquire']->last_name }} من </p>
    <br>

<! --

    <p>{{ $details['model']->slug }} حول منتجك </p>
    -->
 <br>
    <p>شكرا لك</p>
</body>

</html>
