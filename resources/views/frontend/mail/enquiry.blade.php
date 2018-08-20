<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquriy Mail</title>
</head>
<body>
<h1>New Enquiry Mail</h1>
{!! $name !!}
<table width="100%">
    <tr><td width="20%">Name:</td><td>{!! $name !!}</td></tr>
    <tr><td>Product Name:</td><td>{!! $productname !!}</td></tr>
    <tr><td>Email:</td><td>{!! $email !!}</td></tr>
    <tr><td>Phone Number:</td><td>{!! $phone !!}</td></tr>
    <tr><td>Message:</td><td>{!! $bodyMessage !!}</td></tr>
</table>
</body>
</html>