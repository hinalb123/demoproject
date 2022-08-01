<?php

namespace App\Http\Controllers;

use App\Library\VoiceRSS;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TextToSpeechController extends Controller
{
    public function index()
   	{
   		$link = "";
   		return view('text-to-speech', compact('link'));
   	}
	   public function getResources()
	   {
			   // Get the authorized client object and fetch the resources.
			   $client = GoogleCalendar::oauth();
			   return GoogleCalendar::getResources($client);
	   
		}
	   
	   public function connect()
	   {
			   $client = GoogleCalendar::getClient();
			   $authUrl = $client->createAuthUrl();
			   return redirect($authUrl);
		}
		public function store()
		{
			$client = GoogleCalendar::getClient();
			$authCode = request('code');
			// Load previously authorized credentials from a file.
			$credentialsPath = storage_path('keys/client_secret_generated.json');
			// Exchange authorization code for an access token.
			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
	
			// Store the credentials to disk.
			if (!file_exists(dirname($credentialsPath))) {
				mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, json_encode($accessToken));
			return redirect('/google-calendar')->with('message', 'Credentials saved');
		}

   	public function TextToSpeechConvert(Request $request)
   	{	

	   	$request->validate([
		    'text' => 'required|string|max:500',
		    "lan" => "required",		    
		]);

		try {		
			
			$tts = new VoiceRSS;
			$voice = $tts->speech([
			    'key' => env('VOICE_RSS_API_KEY'),
			    'hl' =>  $request->lan,
			    'src' => $request->text,
			    'r' => '0',
			    'c' => 'mp3',
			    'f' => '44khz_16bit_stereo',
			    'ssml' => 'false',
			    'b64' => 'false'
			]);	
				
			$filename = Str::uuid().'.mp3';
			if( empty($voice["error"]) ) {		

				$rawData = $voice["response"];	
				
				if (!File::exists(storage_path('app/public/speeches')))
				{
					Storage::makeDirectory(public_path('storage/speeches'));
				}

				Storage::disk('speeches')->put($filename, $rawData);
				$speechFilelink =  asset('storage/speeches/'.$filename);							   		                 
			   	$urls["play-url"] = $speechFilelink;		   	
			   	$urls["download-file"] = $filename;			   
			    $data = array('status' => 200, 'responseText' => $urls);
	            return response()->json($data);		
			}

	   		$data = array('status' => 400, 'responseText' => "Please try again!");
            return response()->json($data);     

		} 
		catch (SitemapParserException $e) {
		    $data = array('status' => 400, 'responseText' => $e->getMessage());
            return response()->json($data);
		}                     
   	}
}