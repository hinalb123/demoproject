<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Stripe;
use Response;

class UserController extends Controller
{
    public function adduser(){
        return view('adduser');
    }

    public function rolesave(Request $request){
        $data=User::where('id',$request->userid)->first();
        
        // dd($user);
        if($data == null){
            
            return "user not found";
        }
        $user = User::with('blogusers')->findOrFail($request->userid);

        if ($user->blogusers === null)
        {
            // $company = new Role(['rolename' => 'Test']);
            // $user->blogusers()->save($company);
            $user=Role::create([
                'rolename'=>$request->rolename,
                'userid'=>$request->userid,
               
            ]);
        }
        else
        {
            $user=Role::where('userid', $request->userid)->update([
                'rolename'=>$request->rolename,
                'userid'=>$request->userid,
            ]);
            // $user->company->update(['rolename' => 'Test']);
        }
  
    }

    public function saveuser(UserRequest $request){

        $profile = $request->file('profile')->store('profileimage', ['disk' => 'public']);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'profile'=>$profile,
        ]);
        return redirect()->route('showuser');

    }
public function show(){
    
    return view('showuser');
}
    public function showuser(Request $request){
        $user=User::with('blogusers')->get();
        dd($user);
       
        if($request->has('titlesearch')){
          
            $user = User::search($request->titlesearch)
                ->paginate(6);
              
        }else{
            $user = User::paginate(6);
        }

        return Response::json($user);
        // return view('showuser',compact('user'));
    }
    public function deleteuser($id){
        
        $user=User::find($id)->delete();
        return redirect()->route('showuser');

    }
    public function updateuser($id){

        $user=User::where('id',$id)->first();
        return view('updateuser',compact('user'));
    }

    public function edituser(Request $request){

        if ($request->has('profile')) {
            $path = $request->file('profile')->store('profileimage', ['disk' => 'public']);
          
            $user=User::where('id', $request->id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
                'profile'=>$path,
            ]);
        } else {
            $user=User::where('id', $request->id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,

            ]);

        }      

        return redirect()->route('showuser');

    }

    public function callapi(Request $request){
        // $client = new Client();
        // $request = new Request('GET', 'https://api.streamsb.com/api/folder/create?key=49124sf11w8nkvpy4zmvw&fld_id=15&name=New Folder1');
        // $res = $client->sendAsync($request)->wait();
        // echo $res->getBody();



        $client = new \GuzzleHttp\Client();
        $folderid=$request->folderid;
        $name=$request->name;



        $main_url = "https://api.streamsb.com/api/folder/create?key=49124sf11w8nkvpy4zmvw&fld_id=".$folderid."&name=".$name;
        $response = $client->request('GET', $main_url, [
            'headers' => [  
            ],
        ]);
        $response_data = $response->getBody()->read(1024);
        $response_data = json_decode($response_data);
        return $response_data;
        
        // return Http::get('https://api.streamsb.com/api/folder/create?key=49124sf11w8nkvpy4zmvw&fld_id=50&name=New Folder1')->json();
    }


    public function fileupload1(Request $request){
        $client = new \GuzzleHttp\Client();
        // $file = 'http://techslides.com/demos/sample-videos/small.webm';
       
        $file = $request->file('fileupload')->store('profileimage', ['disk' => 'public']);

        $main_url="https://ssuploader.streamsb.com/upload/01";
        // $main_url = "https://api.streamsb.com/api/upload/url?key=49124sf11w8nkvpy4zmvw&url=http://techslides.com/demos/sample-videos/small.webm";
        // $main_url = "https://api.streamsb.com/api/upload/url?key=49124sf11w8nkvpy4zmvw&url=$file";

        $body = [
            "file" => $file,
            'api_key' => '49124sf11w8nkvpy4zmvw',
            'json'=> "1"
        ];
        $body_data = json_encode($body);
        // dd($body_data);
        $response = $client->request('POST', $main_url, [
            'body' => $body_data,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        $response_data = $response->getBody()->read(1024);
        $response_data = json_decode($response_data);
     
        return $response_data;
    }

    public function fileupload(){
        return view('fileupload');
    }

    public function callapi1(){
        return view('createfolder');
    }

    public function stripe()
    {
        return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
       $stripe= $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
     
    //    Stripe\Charge::create ([
    //             "amount" => 100 * 150,
    //             "currency" => "inr",
    //             "source" => $request->stripeToken,
    //             "description" => "Making test payment." 
    //     ]);
        $stripe->paymentIntents->create([
            'amount' => 2000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            "description" => "Making test payment.",
          ]);
          $d=$stripe->customers->create([
            'description' => 'My First Test Customer',
          ]);

        Session::flash('success', 'Payment has been successfully processed.');
          
        return back();
    }
}
















