<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="float-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <a href="{{route('adduser')}}" class="btn">Add User </a>

    

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="panel panel-primary">
      <div class="panel-heading">User management</div>
      <div class="panel-body">
            <form method="GET" action="{{ route('showuser') }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="titlesearch" class="form-control" placeholder="Enter Title For Search" value="{{ old('titlesearch') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-success">Search</button>
                        </div>
                    </div>
                </div>
            </form>


        

            <div id="portfoliolist">

            </div>
      </div>
</body>


<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    // $('#example').DataTable();

    $.ajax({
                    url: "{{ route('showuser') }}",
                    type: 'get',
                    datatype: 'html',
                    data: {
                        _token:'{{ csrf_token() }}'
                    },
                  
                })
                .done(function(dataResult) {
                    var resultData = dataResult.data;
              
            if (resultData.length > 0) {
                html = '';
                for (i = 0; i < resultData.length; i++) {
                    html += `<div class="portfolio" data-cat="app" style="display: inline-block;" data-bound="">${resultData[i].name  }</div>
                <div class="portfolio" data-cat="app" style="display: inline-block;" data-bound="">${resultData[i].email}
            </div><br>`

                }
                $('#portfoliolist').html(html);
            }

                })
});


function deleteuser(id) {

    var token = $("meta[name='csrf-token']").attr("content");

    swal({
            title: "Are you sure want to delete!!?",
            //  text: "Are u sure ",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: route('deleteuser', id),
                    type: 'GET',
                    data: {
                        'id': id,
                        '_token': token,
                    },
                    success: function() {
                        console.log("it Works");
                        $(".delete" + id).remove();

                    }

                })
            } else {
                swal("Your imaginary file is safe!");
            }
        });




    // $.ajax({
    //     url: route('deleteuser',id),
    //     type: 'GET',
    //     data: {
    //         'id': id,
    //         '_token': token,
    //     },
    //     success: function (){
    //         console.log("it Works");
    //         $(".delete"+id).remove();

    //     }

    // })
}
</script>

</html>