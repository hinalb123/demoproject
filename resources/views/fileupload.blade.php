<html>

<head>

<body>

    <form action="{{route('fileupload1')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="fileupload">
        <br>
        <input type="submit" value="save">
    </form>
    <!-- <form enctype="multipart/form-data" action="" method="post">
   
    <input type="hidden" name="api_key" value="948324jkl3h45h">
    <input name="file" type="file">
    <input name="json" value="1">
    <input type="submit">
    </form> -->
</body>
</head>

</html>