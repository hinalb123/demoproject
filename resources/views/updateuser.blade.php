<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <form action="{{route('edituser')}}" method="post" enctype="multipart/form-data">
        @csrf

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <input type="hidden" name="id" value="{{$user->id}}">

        <div>
            <label for="Name">Name</label>
            <input type="text" name="name" class="form-control col-6" value="{{$user->name}}">
        </div>

        <div class="mt-4">
            <label for="Email">Email</label>
            <input type="text" name="email" class="form-control col-6" value="{{$user->email}}">
        </div>

        <div class="mt-4">
            <label for="Password">Password</label>
            <input type="password" name="password" class="form-control col-6" value="{{$user->password}}">
        </div>


        <div class="mt-4">
            <label for="Profile">Profile<img height="100px" width="100px" src="{{url(Storage::url($user->profile))}}"
                    alt=""></label>
            <input type="file" name="profile" class="form-control col-6">
        </div>

        <div class="mt-2">
            <input type="submit" name="submit" class="btn-primary btn">
        </div>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

</html>