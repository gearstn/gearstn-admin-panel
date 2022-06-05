<html>
<head>
    <title>GearsTN</title>
</head>
<body>
    <h1>Hello {{ $details['buyer']->company_name }}</h1>
    <br>
    <p>{{ $details['seller']->company_name }} has received you message and they will respond shortly.</p>
    <br><br><br>
    <h1> {{ $details['buyer']->company_name }} مرحبا</h1>
    <br>
    <p>  .رسالتك وسوف يتم الرد قريبا{{ $details['seller']->company_name }}تلقى</p>

</body>
</html>
