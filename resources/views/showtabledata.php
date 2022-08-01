<!-- <table class="table table-bordered">
<thead>
    <th>Id</th>
    <th>Title</th>
    <th>Creation Date</th>
    <th>Updated Date</th>
</thead>
<tbody>
    @if($user->count())
        @foreach($user as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">There are no data.</td>
        </tr>
    @endif
</tbody>
</table> -->


<!-- <table id="example" class="display" style="width:100%">
        @routes
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $row)
            <tr class="hidden delete{{$row->id}}" value="{{$row->id}}">
                <td>{{$row->name}}</td>
                <td>{{$row->email}}</td>
                <td><img height="100px" width="100px" src="{{url(Storage::url($row->profile))}}" alt=""></td>
                <td><button type="submit" onclick="deleteuser({{$row->id}});" class="btn-danger btn">Delete</td>
                <td><a href="{{route('updateuser',[$row->id])}}" class="btn-primary btn">Update</td>
            </tr>
            @endforeach
        </tbody>
    </table> -->

                <!-- {{ $user->links() }} -->
