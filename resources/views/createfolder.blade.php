<html>

<head>

<body>

    <form action="{{route('callapi')}}" method="post">
        @csrf
        <input type="text" name="folderid">folderid
        <br>
        <input type="text" name="name">namefolder
        <br>
        <input type="submit" value="save">
    </form>
</body>
</head>

</html>