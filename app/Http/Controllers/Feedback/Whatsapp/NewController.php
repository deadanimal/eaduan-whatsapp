<?php

namespace App\Http\Controllers\Feedback\Whatsapp;

use App\Http\Controllers\Controller;
use App\Library\Feedback\Whatsapp\WhatsappMessageLibrary;
use App\Library\Feedback\Whatsapp\WhatsappTemplateLibrary;
use App\Models\Feedback\FeedWhatsapp;
use App\Models\Feedback\FeedWhatsappDetail;
use App\Models\Feedback\Laporanhelpdesk;
use App\Models\Feedback\Dokumenfasa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\UserAccess;
use App\Aduan\AdminCase;
use App\Aduan\AdminCaseDoc;
use App\Aduan\AdminCaseDetail;
use Carbon\Carbon;
use App\User;
use App\Repositories\RunnerRepository;
use Illuminate\Support\Facades\Auth;
use App\Letter;
use PDF;
use App\Attachment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AduanTerimaAdmin;

use JavaScript;
use DB;

use App\Laporan\Helpdesk;


class NewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }

    /**
     * get DT data for new whatsapp feedback
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function dt(Request $request)
    {
        $data = FeedWhatsapp::with('detail')
            ->where('is_active', true)
            ->whereNull('supporter_id')
            ->get();

        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('phone', function (FeedWhatsapp $data) {
                return $data->name . '(' . $data->phone . ')';
            })
            ->editColumn('last_message', function (FeedWhatsapp $data) {
                return str_replace(PHP_EOL, '_n_', $data->detail->last()->message ?? '');
            })
            ->addColumn('action', '
                <a href="{{ route("whatsapp.show", $id) }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="right" title="Add to my task">
                <i class="fa fa-eye"></i></a>
            ');
        return $datatables->make(true);
    }
	
	public function tugasansaya(Request $request)
    {
		$json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		// dd($json);
		return view('feedback.whatsapp.tugasansaya.index', [
            'biliks' => $biliks
        ]);
    }
	
	public function caritugasan(Request $request)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $phone = $request->phone;
        $name = $request->name;
        // dd($name, $phone);
		
		//curl post request
		$ch = curl_init($url);

		$jsonData = array(
			"phone" => $phone,
            "name" => $name,
		);

        if ($phone != null && $name == null) {
            $jsonData = array(
                "phone" => $phone,
            );
        } else if ($phone == null && $name != null) {
            $jsonData = array(
                "name" => $name,
            );
        } else {
            echo("error");
        }

		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
       
        $biliks = json_decode($result, TRUE)['rooms'];
		
		return view('feedback.whatsapp.tugasansaya.index', [
            'biliks' => $biliks
        ]);
    }
	
	public function aktifke (Request $request)
	{

        $get_data = callAPI('GET', 'https://murai.io/api/whatsapp/numbers/601154212526/rooms', false);
        $response = json_decode($get_data, true);
        dd($response);

        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
		$json = json_decode($response);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.aktifke.index', [
            'biliks' => $biliks
        ]);
	}

    public function cariaktif(Request $request)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $phone = $request->phone;
        $name = $request->name;
        $officer_name = $request->officer_name;
        // dd($name, $phone);
		
		//curl post request
		$ch = curl_init($url);

        if ($phone != null && $name == null && $officer_name == null) {
            $jsonData = array(
                "phone" => $phone,
            );
        } else if ($phone == null && $name != null && $officer_name == null) {
            $jsonData = array(
                "name" => $name,
            );
        }else if ($phone == null && $name == null && $officer_name != null) {
            $jsonData = array(
                "officer_name" => $officer_name,
            );
        } else {
            $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
            $biliks = json_encode($json);
            $biliks = json_decode($biliks, TRUE)['rooms'];
            
            return view('feedback.whatsapp.aktifke.index', [
                'biliks' => $biliks
            ]);
        }

		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
       
        $biliks = json_decode($result, TRUE)['rooms'];
		
		return view('feedback.whatsapp.aktifke.index', [
            'biliks' => $biliks
        ]);
    }
	
	public function buang_tugas ($room_id){
		$url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/" . $room_id . "/officer";
		
		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = array(
			"officer_name" => "",
		);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//Execute the request
		$result = curl_exec($ch);
		
		// Close cURL resource
		curl_close($ch);

        $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.aktifke.index', [
            'biliks' => $biliks
        ]);
	}
	
	public function tambah_tugas ($room_id, Request $request){
		$url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/" . $room_id . "/officer";
		
		$ch = curl_init($url);
		$jsonData = array(
			"officer_name" => $request->user()->name,
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

        $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.aktifke.index', [
            'biliks' => $biliks
        ]);
	}

    public function selesai_mesej ($room_id){
		$url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/" . $room_id . "/officer";
		
		$ch = curl_init($url);
		$jsonData = array(
			"officer_name" => 'Selesai',
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

        $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.semuaa.index', [
            'biliks' => $biliks
        ]);
	}
	
	public function semuaa (Request $request)
	{
		$json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.semuaa.index', [
            'biliks' => $biliks
        ]);
	}

    public function carisemuaa(Request $request)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $phone = $request->phone;
        $name = $request->name;
        $officer_name = $request->officer_name;
        // dd($name, $phone);
		
		//curl post request
		$ch = curl_init($url);

        if ($phone != null && $name == null && $officer_name == null) {
            $jsonData = array(
                "phone" => $phone,
            );
        } else if ($phone == null && $name != null && $officer_name == null) {
            $jsonData = array(
                "name" => $name,
            );
        }else if ($phone == null && $name == null && $officer_name != null) {
            $jsonData = array(
                "officer_name" => $officer_name,
            );
        } else {
            $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
            $biliks = json_encode($json);
            $biliks = json_decode($biliks, TRUE)['rooms'];
            
            return view('feedback.whatsapp.semuaa.index', [
                'biliks' => $biliks
            ]);
        }

		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
       
        $biliks = json_decode($result, TRUE)['rooms'];
		
		return view('feedback.whatsapp.semuaa.index', [
            'biliks' => $biliks
        ]);
    }

    public function aktif_bot($room_id)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/" . $room_id . "/activate";
        $json = json_decode(file_get_contents($url), true);

        $json = json_decode(file_get_contents('https://murai.io/api/whatsapp/numbers/601154212526/rooms'), true);
		$biliks = json_encode($json);
        $biliks = json_decode($biliks, TRUE)['rooms'];
		
		return view('feedback.whatsapp.semuaa.index', [
            'biliks' => $biliks
        ]);
    }
	
	public function paparaktifke($id, Request $request)
    {
		$url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/".$id."/messages";
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
		$trytest = json_decode($response);
        $try = json_encode($trytest);
        $mesejs = json_decode($try, TRUE)['messages'];
        $rooms = json_decode($try, TRUE)['room'];

        $user = $request->user()->id;
		$role = UserAccess::where('user_id', $user)->first()->role_code;
		$jenis_user = $role;

        
        // dd($mesejs);

        return view('feedback.whatsapp.paparaktif.index', [
            'mesejs' => $mesejs,
            'rooms' => $rooms,
            'jenis_user' => $jenis_user
        ]);
    }
	
	public function paparmesej($id)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $mesejs = json_decode(file_get_contents($url), true);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        $room = json_decode($try, TRUE)['room'];
        // dd($mesejs);
		
        return view('feedback.whatsapp.paparmesej.index', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }

    public function paparsemua($id)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $mesejs = json_decode(file_get_contents($url), true);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        $room = json_decode($try, TRUE)['room'];
        krsort($mesejs);
        // dd($mesejs);
		
        return view('feedback.whatsapp.paparsemua.index', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }
	
	public function hantarmesej(Request $request, $id)
    {
		$hantar = $request->hantar;
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";

		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = array(
			"message_text" => $hantar,
		);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		
		//hide response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//Execute the request
		$result = curl_exec($ch);
		
		// Close cURL resource
		curl_close($ch);

        $mesejs = json_decode(file_get_contents($url), true);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        $room = json_decode($try, TRUE)['room'];
		
        return view('feedback.whatsapp.paparmesej.index', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }
	
	public function create_auto()
    {
		return view('feedback.whatsapp.create_auto.index');
    }

    public function auto_attach()
    {
		return view('feedback.whatsapp.auto_attach.index');
    }

   
	public function potong($id, $index, Request $request)
    {
        $mesej_id = $id;
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $mesejs = json_decode(file_get_contents($url), true);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        //dd($mesejs[$index]['message_text']);

        $media_and_created_at = [];
        foreach ($mesejs as $key => $datum) {
            
            if($mesejs[$key]['media_url'] != null){
                $temp = (object) [];
                //array_push($mediaurl, $mesejs[$key]['media_url']);
                $temp -> media_url = $mesejs[$key]['media_url'];
                $temp -> created_at = $mesejs[$key]['created_at'];
                array_push($media_and_created_at, $temp);
            }  
        }

        
        // dd($media_and_created_at);

        $long_string = $mesejs[$index]['message_text'];
        $array_string = explode("\n", $long_string);
        echo '<br/>';

        $engl = implode(" ", array_slice(explode(" ", $array_string[0]),0));
        $engl_string = "Details:";
        $mal_string = "Butiran";
        // dd($engl, $engl_string);
        if ($engl == $engl_string){
            # nama
            $nama = implode(" ", array_slice(explode(" ", $array_string[1]),5));

            # ic number
            $ic = implode(" ", array_slice(explode(" ", $array_string[2]),3));

            # alamat
            $alamat = implode(" ", array_slice(explode(" ", $array_string[3]),3));

            # telefon
            $telefon = implode(" ", array_slice(explode(" ", $array_string[4]),3));

            # email
            $email = implode(" ", array_slice(explode(" ", $array_string[5]),2));

            # nama premis
            $namaprem = implode(" ", array_slice(explode(" ", $array_string[6]),5));

            # alamat premis
            $alprem = implode(" ", array_slice(explode(" ", $array_string[7]),7));

            # keterangan aduan
            $keteranganaduan = implode(" ", array_slice(explode(" ", $array_string[8]),4));

            // dd($nama, $ic, $alamat, $telefon, $email);
        }else if ($engl == $mal_string){
            # nama
            $nama = implode(" ", array_slice(explode(" ", $array_string[1]),4));

            # ic number
            $ic = implode(" ", array_slice(explode(" ", $array_string[2]),5));

            # alamat
            $alamat = implode(" ", array_slice(explode(" ", $array_string[3]),4));

            # telefon
            $telefon = implode(" ", array_slice(explode(" ", $array_string[4]),3));

            # email
            $email = implode(" ", array_slice(explode(" ", $array_string[5]),2));

            # nama premis
            $namaprem = implode(" ", array_slice(explode(" ", $array_string[6]),5));

            # alamat premis
            $alprem = implode(" ", array_slice(explode(" ", $array_string[7]),6));

            # keterangan aduan
            $keteranganaduan = implode(" ", array_slice(explode(" ", $array_string[8]),3));

            // dd($nama, $ic, $alamat, $telefon, $email);
        } else {
            echo "<script>alert('Sila pilih mesej aduan');</script>";

            $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
            $mesejs = json_decode(file_get_contents($url), true);
            $try = json_encode($mesejs);
            $mesejs = json_decode($try, TRUE)['messages'];

            $room = json_decode($try, TRUE)['room'];
            return view('feedback.whatsapp.paparmesej.indexfeedback.whatsapp.paparmesej.index', [
                'mesejs' => $mesejs,
                'room' => $room
            ]);

        }

        $feedback = $request->only('feedback');
        $sender = $request->only('sender');
        $data['CA_CMPLCAT'] = $request->old('CA_CMPLCAT') ?? null;
        $data['CA_AGAINST_PREMISE'] = $request->old('CA_AGAINST_PREMISE') ?? null;
        $data['CA_ONLINECMPL_PROVIDER'] = $request->old('CA_ONLINECMPL_PROVIDER') ?? null;
        $data['CA_ONLINECMPL_IND'] = $request->old('CA_ONLINECMPL_IND') ?? null;
        $data['CA_ONLINEADD_IND'] = $request->old('CA_ONLINEADD_IND') ?? null;
        $data['againstonlinecomplaint'] = $data['CA_CMPLCAT'] == 'BPGK 19' || $data['CA_AGAINST_PREMISE'] == 'P25';
        // $data['providercaseno'] = $data['CA_ONLINECMPL_IND'] == 'on' && $data['againstonlinecomplaint'];
        $data['providercaseno'] = in_array($data['CA_ONLINECMPL_IND'], ['1', 'on']) && $data['againstonlinecomplaint'];
        $data['providerurl'] = $data['againstonlinecomplaint'] && $data['CA_ONLINECMPL_PROVIDER'] == '999';
        $data['againstaddress'] = (empty($data['CA_CMPLCAT']) && empty($data['CA_AGAINST_PREMISE']))
            || ($data['CA_CMPLCAT'] != 'BPGK 19' && $data['CA_AGAINST_PREMISE'] != 'P25')
            // || ($data['CA_ONLINEADD_IND'] == 'on' && $data['againstonlinecomplaint']);
            || (in_array($data['CA_ONLINEADD_IND'], ['1', 'on']) && $data['againstonlinecomplaint']);

        JavaScript::put([
            'feedback' => $feedback,
            'sender' => $sender
        ]);

        $mRefWarganegara = DB::table('sys_ref')
            ->where(['cat' => '947', 'status' => '1'])
            ->select('code', 'descr')
            ->get();
        
        return view('feedback.whatsapp.create_auto.index', [
            'mesej_id'=>$mesej_id,
            'nama' => $nama,
            'ic' => $ic,
            'alamat' => $alamat,
            'telefon' => $telefon,
            'email' => $email,
            'namaprem' => $namaprem,
            'alprem' => $alprem,
            'keteranganaduan' => $keteranganaduan,
            'media_and_created_at' => json_encode($media_and_created_at),
            'info'=>$long_string
        ])->with(compact('mRefWarganegara', 'feedback', 'data'));
    }

    public function potong2($id, $index, Request $request)
    {
        // dd($array_key);
        $mesej_id = $id;
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $mesejs = json_decode(file_get_contents($url), true);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];

        $keymesej = $request->hantar2;
        $array_key = explode(",", $keymesej);
        // dd($array_key);
        $media_and_created_at = [];
        $info = [];
        foreach($array_key as $kunci){
            // dd($kunci);
            $themesej = $mesejs[$kunci]['message_text'];
            array_push($info, $themesej);
            $array_string = explode("\n", $themesej);

            $themesej = implode(" ", array_slice(explode(" ", $array_string[0]),0));
            // dd($themesej);

            if ($themesej == "Details:"){
                # nama
                $nama = implode(" ", array_slice(explode(" ", $array_string[1]),5));
    
                # ic number
                $ic = implode(" ", array_slice(explode(" ", $array_string[2]),3));
    
                # alamat
                $alamat = implode(" ", array_slice(explode(" ", $array_string[3]),3));
    
                # telefon
                $telefon = implode(" ", array_slice(explode(" ", $array_string[4]),3));
    
                # email
                $email = implode(" ", array_slice(explode(" ", $array_string[5]),2));
    
                # nama premis
                $namaprem = implode(" ", array_slice(explode(" ", $array_string[6]),5));
    
                # alamat premis
                $alprem = implode(" ", array_slice(explode(" ", $array_string[7]),7));
    
                # keterangan aduan
                $keteranganaduan = implode(" ", array_slice(explode(" ", $array_string[8]),4));
    
                // dd($nama, $ic, $alamat, $telefon, $email);
            }else if ($themesej == "Butiran"){
                # nama
                $nama = implode(" ", array_slice(explode(" ", $array_string[1]),4));
    
                # ic number
                $ic = implode(" ", array_slice(explode(" ", $array_string[2]),5));
    
                # alamat
                $alamat = implode(" ", array_slice(explode(" ", $array_string[3]),4));
    
                # telefon
                $telefon = implode(" ", array_slice(explode(" ", $array_string[4]),3));
    
                # email
                $email = implode(" ", array_slice(explode(" ", $array_string[5]),2));
    
                # nama premis
                $namaprem = implode(" ", array_slice(explode(" ", $array_string[6]),5));
    
                # alamat premis
                $alprem = implode(" ", array_slice(explode(" ", $array_string[7]),6));
    
                # keterangan aduan
                $keteranganaduan = implode(" ", array_slice(explode(" ", $array_string[8]),3));
    
                // dd($nama, $ic, $alamat, $telefon, $email);
            }

            if($mesejs[$kunci]['media_url'] != null){
                $temp = (object) [];
                //array_push($mediaurl, $mesejs[$key]['media_url']);
                $temp -> media_url = $mesejs[$kunci]['media_url'];
                $temp -> created_at = $mesejs[$kunci]['created_at'];
                array_push($media_and_created_at, $temp);
            }
        }
// dd($info);
        // dd($nama, $ic, $alamat, $telefon, $email, $media_and_created_at);

        $feedback = $request->only('feedback');
        $sender = $request->only('sender');
        $data['CA_CMPLCAT'] = $request->old('CA_CMPLCAT') ?? null;
        $data['CA_AGAINST_PREMISE'] = $request->old('CA_AGAINST_PREMISE') ?? null;
        $data['CA_ONLINECMPL_PROVIDER'] = $request->old('CA_ONLINECMPL_PROVIDER') ?? null;
        $data['CA_ONLINECMPL_IND'] = $request->old('CA_ONLINECMPL_IND') ?? null;
        $data['CA_ONLINEADD_IND'] = $request->old('CA_ONLINEADD_IND') ?? null;
        $data['againstonlinecomplaint'] = $data['CA_CMPLCAT'] == 'BPGK 19' || $data['CA_AGAINST_PREMISE'] == 'P25';
        // $data['providercaseno'] = $data['CA_ONLINECMPL_IND'] == 'on' && $data['againstonlinecomplaint'];
        $data['providercaseno'] = in_array($data['CA_ONLINECMPL_IND'], ['1', 'on']) && $data['againstonlinecomplaint'];
        $data['providerurl'] = $data['againstonlinecomplaint'] && $data['CA_ONLINECMPL_PROVIDER'] == '999';
        $data['againstaddress'] = (empty($data['CA_CMPLCAT']) && empty($data['CA_AGAINST_PREMISE']))
            || ($data['CA_CMPLCAT'] != 'BPGK 19' && $data['CA_AGAINST_PREMISE'] != 'P25')
            // || ($data['CA_ONLINEADD_IND'] == 'on' && $data['againstonlinecomplaint']);
            || (in_array($data['CA_ONLINEADD_IND'], ['1', 'on']) && $data['againstonlinecomplaint']);

        JavaScript::put([
            'feedback' => $feedback,
            'sender' => $sender
        ]);

        $mRefWarganegara = DB::table('sys_ref')
            ->where(['cat' => '947', 'status' => '1'])
            ->select('code', 'descr')
            ->get();
        
        return view('feedback.whatsapp.create_auto.index', [
            'mesej_id'=>$mesej_id,
            'nama' => $nama,
            'ic' => $ic,
            'alamat' => $alamat,
            'telefon' => $telefon,
            'email' => $email,
            'namaprem' => $namaprem,
            'alprem' => $alprem,
            'keteranganaduan' => $keteranganaduan,
            'media_and_created_at' => json_encode($media_and_created_at),
            'info' => $info
        ])->with(compact('mRefWarganegara', 'feedback', 'data'));
    }

    public function storeauto(Request $request){
        // dd($request);
        $autoattach = json_decode($request->checktest);
        // dd($autoattach[0]->media_url);
        // suppose using this method or
        // if need more secure method using ->only()
        $data = $request->all();

        $request->merge(['CA_ONLINECMPL_AMOUNT' => str_replace(',', '', $request->CA_ONLINECMPL_AMOUNT)]);
        if ($request->CA_CMPLCAT != 'BPGK 19') {
            $request->merge([
                'CA_ONLINECMPL_ACCNO' => NULL,
            ]);
        }
        // $this->validate($request, [
        $validator = Validator::make($request->all(), [
            'CA_RCVTYP' => 'required',
            'CA_SERVICENO' => 'required_if:CA_RCVTYP,S33',
            'CA_DOCNO' => 'required|max:15',
            'CA_EMAIL' => 'required_without_all:CA_MOBILENO,CA_TELNO',
            'CA_MOBILENO' => 'required_without_all:CA_TELNO,CA_EMAIL|max:20',
            'CA_TELNO' => 'required_without_all:CA_MOBILENO,CA_EMAIL|max:20',
            'CA_FAXNO' => 'max:20',
            'CA_NAME' => 'required|max:60',
            'CA_AGE' => 'max:20',
            'CA_POSCD' => 'max:5',
            'CA_STATECD' => 'required',
            'CA_DISTCD' => 'required',
            'CA_NATCD' => 'required',
            'CA_COUNTRYCD' => 'required_if:CA_NATCD,0',
            'CA_CMPLCAT' => 'required',
            'CA_CMPLCD' => 'required',
            'CA_CMPLKEYWORD' => 'required_if:CA_CMPLCAT,BPGK 01|required_if:CA_CMPLCAT,BPGK 03',
            'CA_AGAINST_PREMISE' => 'required_unless:CA_CMPLCAT,BPGK 19',
            'CA_ONLINECMPL_AMOUNT' => 'required|numeric|max:99999999.99',
            'CA_ONLINECMPL_PROVIDER' => 'required_if:CA_CMPLCAT,BPGK 19|required_if:CA_AGAINST_PREMISE,P25',
            'CA_ONLINECMPL_URL' => 'required_if:CA_ONLINECMPL_PROVIDER,999|max:190',
            'CA_ONLINECMPL_PYMNTTYP' => 'required_if:CA_CMPLCAT,BPGK 19',
            'CA_ONLINECMPL_ACCNO' => 'max:80',
            'CA_ONLINECMPL_CASENO' => 'max:80',
            'CA_AGAINSTNM' => 'required|max:190',
            'CA_AGAINST_TELNO' => 'max:20',
            'CA_AGAINST_MOBILENO' => 'max:20',
            'CA_AGAINST_EMAIL' => 'max:20',
            'CA_AGAINST_FAXNO' => 'max:20',
            'CA_AGAINST_POSTCD' => 'max:5',
            'CA_SUMMARY' => 'required',
        ],
            [
                'CA_RCVTYP.required' => 'Ruangan Cara Penerimaan diperlukan.',
                'CA_SERVICENO.required_if' => 'Ruangan No. Tali Khidmat diperlukan.',
                'CA_DOCNO.required' => 'Ruangan No. Kad Pengenalan/Pasport diperlukan.',
                'CA_EMAIL.required_without_all' => 'Sila isikan salah satu maklumat berikut: Emel / No. Telefon (Bimbit) / No. Telefon (Rumah)',
                'CA_EMAIL.max' => 'Jumlah Emel mesti tidak melebihi 20 aksara.',
                'CA_MOBILENO.required_without_all' => 'Sila isikan salah satu maklumat berikut: Emel / No. Telefon (Bimbit) / No. Telefon (Rumah)',
                'CA_TELNO.required_without_all' => 'Sila isikan salah satu maklumat berikut: Emel / No. Telefon (Bimbit) / No. Telefon (Rumah)',
                'CA_NAME.required' => 'Ruangan Nama diperlukan.',
                'CA_NAME.max' => 'Jumlah Nama mesti tidak melebihi 60 aksara.',
                'CA_CMPLCAT.required' => 'Ruangan Kategori diperlukan.',
                'CA_CMPLCD.required' => 'Ruangan Subkategori diperlukan.',
                'CA_AGAINST_PREMISE.required_unless' => 'Ruangan Jenis Premis diperlukan.',
                'CA_AGAINSTNM.required' => 'Ruangan Nama (Syarikat/Premis/Penjual) diperlukan.',
                'CA_AGAINST_EMAIL.max' => 'Jumlah Emel mesti tidak melebihi 20 aksara.',
                'CA_AGAINST_STATECD.required' => 'Ruangan Negeri diperlukan.',
                'CA_AGAINST_DISTCD.required' => 'Ruangan Daerah diperlukan.',
                'CA_AGAINSTADD.required' => 'Ruangan Alamat diperlukan.',
                'CA_AGAINST_POSTCD.required_if' => 'Ruangan Poskod diperlukan.',
                'CA_AGAINST_POSTCD.required' => 'Ruangan Poskod diperlukan.',
                'CA_AGAINST_POSTCD.required_unless' => 'Ruangan Poskod diperlukan.',
                'CA_AGAINST_POSTCD.min' => 'Poskod mesti sekurang-kurangnya 5 angka.',
                'CA_SUMMARY.required' => 'Ruangan Keterangan Aduan diperlukan.',
                'CA_NATCD.required' => 'Ruangan Warganegara diperlukan.',
                'CA_POSCD.min' => 'Poskod mesti sekurang-kurangnya 5 angka.',
                'CA_STATECD.required' => 'Ruangan Negeri diperlukan.',
                'CA_DISTCD.required' => 'Ruangan Daerah diperlukan.',
                'CA_COUNTRYCD.required_if' => 'Ruangan Negara Asal diperlukan.',
                'CA_CMPLKEYWORD.required_if' => 'Ruangan Jenis Barangan diperlukan.',
                'CA_ONLINECMPL_PROVIDER.required_if' => 'Ruangan Pembekal Perkhidmatan diperlukan.',
                'CA_ONLINECMPL_URL.required_if' => 'Ruangan Laman Web / URL / ID diperlukan.',
                'CA_ONLINECMPL_AMOUNT.required' => 'Ruangan Jumlah Kerugian (RM) diperlukan.',
                'CA_ONLINECMPL_PYMNTTYP.required_if' => 'Ruangan Cara Pembayaran diperlukan.',
                'CA_ONLINECMPL_BANKCD.required' => 'Ruangan Nama Bank diperlukan.',
                'CA_ONLINECMPL_ACCNO.required' => 'Ruangan No. Akaun Bank diperlukan.',
//            'CA_ONLINECMPL_CASENO.required_if' => 'Ruangan No. Aduan Rujukan diperlukan.',
            ]);
        $validator->sometimes(['CA_AGAINSTADD', 'CA_AGAINST_STATECD', 'CA_AGAINST_DISTCD'], 'required', function ($input) {
            return (empty($input->CA_CMPLCAT) && empty($input->CA_AGAINST_PREMISE))
                ||
                ($input->CA_CMPLCAT != 'BPGK 19' && $input->CA_AGAINST_PREMISE != 'P25')
                ||
                // ($input->CA_ONLINEADD_IND == 'on' &&
                (in_array($input->CA_ONLINEADD_IND, ['1', 'on']) &&
                    ($input->CA_CMPLCAT == 'BPGK 19' || $input->CA_AGAINST_PREMISE == 'P25')
                );
        });
        $validator->sometimes(['CA_ONLINECMPL_BANKCD', 'CA_ONLINECMPL_ACCNO'], 'required', function ($input) {
            return $input->CA_CMPLCAT == 'BPGK 19'
                && in_array($input->CA_ONLINECMPL_PYMNTTYP, ['CRC', 'OTF', 'CDM']);
        });
        $validator->validate();

        $mAdminCase = new AdminCase;
        $mAdminCase->fill($request->all());

        if (in_array($request->CA_CMPLCAT, ['BPGK 01', 'BPGK 03'])) {
            $mAdminCase->CA_CMPLKEYWORD = $request->CA_CMPLKEYWORD;
        } else {
            $mAdminCase->CA_CMPLKEYWORD = NULL;
        }

        if ($request->CA_CMPLCAT == 'BPGK 19' || $request->CA_AGAINST_PREMISE == 'P25') {
            if ($request->CA_ONLINECMPL_IND) {
                $mAdminCase->CA_ONLINECMPL_IND = '1';
                $mAdminCase->CA_ONLINECMPL_CASENO = $request->CA_ONLINECMPL_CASENO;
            } else {
                $mAdminCase->CA_ONLINECMPL_IND = '0';
                $mAdminCase->CA_ONLINECMPL_CASENO = NULL;
            }

            if ($request->CA_ONLINEADD_IND) {
                $mAdminCase->CA_ONLINEADD_IND = '1';
            } else {
                $mAdminCase->CA_ONLINEADD_IND = '0';
            }

            $mAdminCase->CA_ONLINECMPL_URL = $request->CA_ONLINECMPL_URL;
            if ($request->CA_CMPLCAT == 'BPGK 19') {
                $mAdminCase->CA_ONLINECMPL_PYMNTTYP = $request->CA_ONLINECMPL_PYMNTTYP;
                if (in_array($request->CA_ONLINECMPL_PYMNTTYP, ['CRC', 'OTF', 'CDM'])) {
                    $mAdminCase->CA_ONLINECMPL_BANKCD = $request->CA_ONLINECMPL_BANKCD;
                    $mAdminCase->CA_ONLINECMPL_ACCNO = $request->CA_ONLINECMPL_ACCNO;
                }
            }
        } else {
            $mAdminCase->CA_ONLINECMPL_URL = NULL;
        }

//        $mAdminCase->CA_CASEID = $z;
        $mAdminCase->CA_INVSTS = '10'; // DERAF
//        $mAdminCase->CA_INVSTS = 1;
        $mAdminCase->CA_CASESTS = 1;
        $mAdminCase->CA_RCVTYP = request('CA_RCVTYP');
        $mAdminCase->CA_RCVBY = request('CA_RCVBY');
        // $mAdminCase->CA_RCVDT = Carbon::now();
        $mAdminCase->CA_RCVDT = Carbon::parse(request('CA_RCVDT'))->toDateTimeString();
        $mAdminCase->CA_DOCNO = request('CA_DOCNO');
        $mAdminCase->CA_NAME = request('CA_NAME');
        $mAdminCase->CA_EMAIL = request('CA_EMAIL');
        $mAdminCase->CA_MOBILENO = request('CA_MOBILENO');
        $mAdminCase->CA_TELNO = request('CA_TELNO');
        $mAdminCase->CA_FAXNO = request('CA_FAXNO');
        $mAdminCase->CA_SEXCD = request('CA_SEXCD');
        $mAdminCase->CA_AGE = request('CA_AGE');
        $mAdminCase->CA_ADDR = request('CA_ADDR');
        $mAdminCase->CA_RACECD = request('CA_RACECD');
        $mAdminCase->CA_POSCD = request('CA_POSCD');
        $mAdminCase->CA_STATECD = request('CA_STATECD');
        $mAdminCase->CA_DISTCD = request('CA_DISTCD');
        $mAdminCase->CA_NATCD = request('CA_NATCD');
        $mAdminCase->CA_COUNTRYCD = request('CA_COUNTRYCD');
        $mAdminCase->CA_CMPLCAT = request('CA_CMPLCAT');
        $mAdminCase->CA_CMPLCD = request('CA_CMPLCD');
        $mAdminCase->CA_AGAINST_PREMISE = request('CA_AGAINST_PREMISE');
        $mAdminCase->CA_AGAINSTNM = request('CA_AGAINSTNM');
        $mAdminCase->CA_AGAINST_TELNO = request('CA_AGAINST_TELNO');
        $mAdminCase->CA_AGAINST_MOBILENO = request('CA_AGAINST_MOBILENO');
        $mAdminCase->CA_AGAINST_EMAIL = request('CA_AGAINST_EMAIL');
        $mAdminCase->CA_AGAINST_FAXNO = request('CA_AGAINST_FAXNO');
        $mAdminCase->CA_AGAINSTADD = request('CA_AGAINSTADD');
        $mAdminCase->CA_AGAINST_POSTCD = request('CA_AGAINST_POSTCD');
        $mAdminCase->CA_AGAINST_STATECD = request('CA_AGAINST_STATECD');
        $mAdminCase->CA_AGAINST_DISTCD = request('CA_AGAINST_DISTCD');
        $mAdminCase->CA_SUMMARY = request('CA_SUMMARY');
        $DeptCd = explode(' ', $mAdminCase->CA_CMPLCAT)[0];
        $mAdminCase->CA_DEPTCD = $DeptCd;
        $mAdminCase->CA_ONLINECMPL_AMOUNT = str_replace(',', '', $request->CA_ONLINECMPL_AMOUNT);

        // if ($request->CA_ONLINEADD_IND == 'on' || $request->CA_CMPLCAT != 'BPGK 19') {
        if (($request->CA_CMPLCAT != 'BPGK 19' && $request->CA_AGAINST_PREMISE != 'P25')
            ||
            // ($request->CA_ONLINEADD_IND == 'on' &&
            (in_array($request->CA_ONLINEADD_IND, ['1', 'on']) &&
                ($request->CA_CMPLCAT == 'BPGK 19' || $request->CA_AGAINST_PREMISE == 'P25')
            )) {
            $StateCd = $request->CA_AGAINST_STATECD;
            $DistCd = $request->CA_AGAINST_DISTCD;
        } else {
            $StateCd = $mAdminCase->CA_STATECD;
            $DistCd = $mAdminCase->CA_DISTCD;
            $mAdminCase->CA_AGAINSTADD = NULL;
            $mAdminCase->CA_AGAINST_POSTCD = NULL;
            $mAdminCase->CA_AGAINST_STATECD = NULL;
            $mAdminCase->CA_AGAINST_DISTCD = NULL;
        }
        if ($request->CA_ROUTETOHQIND && $request->CA_ROUTETOHQIND == 'on') {
            $mAdminCase->CA_ROUTETOHQIND = '1';
//            $mAdminCase->CA_BRNCD = $this->AduanRoute($StateCd, $DistCd, $DeptCd, true);
            $mAdminCase->CA_BRNCD = 'WHQR5';
        } else {
            $mAdminCase->CA_ROUTETOHQIND = '0';
            $mAdminCase->CA_BRNCD = $this->AduanRoute($StateCd, $DistCd, $DeptCd, false);
        }

        // For feedback module usage:
        if (in_array($data['FEED_TYPE'], ['ws', 'telegram'])) {
            $ids = explode(';', $data['FEED_ID']);

            switch ($data['FEED_TYPE']) {
                case 'ws':
                    $feedback_module = FeedWhatsappDetail::find($ids[0]);
                    $feedback_module_id = $feedback_module->feed_whatsapp_id;
                    break;
                case 'telegram':
                    $feedback_module = FeedTelegramDetail::find($ids[0]);
                    $feedback_module_id = $feedback_module->feed_telegram_id;
                    break;
            }

            $mAdminCase->feedback_module_id = $feedback_module_id;
        }

        if ($mAdminCase->save()) {
            $mCaseDetail = new AdminCaseDetail;
            $mCaseDetail->CD_CASEID = $mAdminCase->id;
            $mCaseDetail->CD_TYPE = 'D';
            $mCaseDetail->CD_ACTTYPE = 'CLS';
            $mCaseDetail->CD_INVSTS = $mAdminCase->CA_INVSTS;
            $mCaseDetail->CD_CASESTS = $mAdminCase->CA_CASESTS;
            $mCaseDetail->CD_CURSTS = '1';


            if ($mCaseDetail->save()) {

                if ($data['CA_IMAGE'] != '') {
                    $ca_images = explode(';', $data['CA_IMAGE']);

                    foreach ($ca_images as $ca_image) {
                        $this->getAttachmentByUrl($mAdminCase->id, $ca_image);
                    }
                }

                // For feedback module usage:
                // Change all selected feed to is_ticketed = 1
                switch ($data['FEED_TYPE']) {
                    case 'ws':
                        WhatsappDetailRepository::linkFeedWithTicket($data['FEED_ID'], $mAdminCase->id);
                        break;
                    case 'telegram':
                        TelegramDetailRepository::linkFeedWithTicket($data['FEED_ID'], $mAdminCase->id);
                        break;
                }

                foreach ($autoattach as $key => $aa){
                    //if () {}

                    $mAdminCaseDoc = new AdminCaseDoc();
                    $mAdminCaseDoc->CC_CASEID = $mAdminCase->id;
                    $mAdminCaseDoc->CC_PATH = $aa->media_url;
                    $mAdminCaseDoc->CC_IMG = "Whatsapp";
                    $mAdminCaseDoc->CC_IMG_NAME = $mAdminCase->CA_MOBILENO."-".$key;
                    $mAdminCaseDoc->CC_REMARKS = "Auto muatnaik dari Whatsapp";
                    $mAdminCaseDoc->CC_IMG_CAT = 1;

                    $mAdminCaseDoc->save();
                }

                $mesej_id = $request->mesej_id;
                // dd($mesej_id);
//                $request->session()->flash('success', 'Aduan telah berjaya ditambah');
//                return redirect()->route('admin-case.edit', $mAdminCase->CA_CASEID);
                  return redirect('feedback/whatsapp/autoattach/'.$mAdminCase->id.'/'.$mesej_id);
                //return view('feedback.whatsapp.autoattach.index');
            }

        }
    }

    public function autoattach($id, $mesej_id){
        // dd($id);
        $model = AdminCase::find($id);
        $countDoc = DB::table('case_doc')
            ->where('CC_CASEID', $id)
            ->count('CC_CASEID');
        $mAdminCaseDoc = AdminCaseDoc::where(['CC_CASEID' => $id])->get();
        // dd($mAdminCaseDoc);
        $mesej_id = $mesej_id;
        $aduan_id = $id;
        return view('feedback.whatsapp.autoattach.index', compact('model', 'countDoc', 'mAdminCaseDoc', 'mesej_id', 'aduan_id'));
    }

    public function deleteattach(Request $request, $id, $mesej_id){
        $mesej_id = $request->mesej_id;
        $aduan_id = $request->aduan_id;
        $aduandoc_id = $request->aduandoc_id;
        $model = AdminCaseDoc::where(['id' => $aduandoc_id])->delete();
        $request->session()->flash('success', 'Bahan Bukti telah berjaya dihapus');
        return redirect('feedback/whatsapp/autoattach/'.$aduan_id.'/'.$mesej_id);
    }

    public function getdatatable($CASEID, $mesej_id)
    {
        $mesej_id = $mesej_id;
        dd($mesej_id);
        $mAdminCaseDoc = AdminCaseDoc::where('CC_CASEID', $CASEID);
        $datatables = DataTables::of($mAdminCaseDoc)
            ->addIndexColumn()
            ->editColumn('CC_IMG_NAME', function(AdminCaseDoc $adminCaseDoc) {
                if($adminCaseDoc->CC_IMG_NAME != ''){
                    // return '<a href='.Storage::disk('bahanpath')->url($adminCaseDoc->CC_PATH.$adminCaseDoc->CC_IMG).' target="_blank">'.$adminCaseDoc->CC_IMG_NAME.'</a>';
                    if($adminCaseDoc->CC_IMG == 'Whatsapp'){
                        return '<a href='.$adminCaseDoc->CC_PATH.'>'.$adminCaseDoc->CC_IMG_NAME.'</a>';
                    }
                    else{
                        return '<a href='.Storage::disk('bahanpath')->url($adminCaseDoc->CC_PATH.$adminCaseDoc->CC_IMG).' target="_blank">'.$adminCaseDoc->CC_IMG_NAME.'</a>';
                    }
                }
                else{
                     return '';
                }  
            })
//            ->editColumn('doc_title', function(AdminCaseDoc $adminCaseDoc) {
//                if($adminCaseDoc->CC_DOCATTCHID != '')
//                    return $adminCaseDoc->attachment->doc_title;
//                else
//                    return '';
//            })
            ->editColumn('updated_at', function(AdminCaseDoc $adminCaseDoc) {
                if($adminCaseDoc->updated_at != '')
                    return $adminCaseDoc->updated_at ? with(new Carbon($adminCaseDoc->updated_at))->format('d-m-Y h:i A') : '';
                else
                    return '';
            })
            ->addColumn('action', function(AdminCaseDoc $adminCaseDoc) {
//                <a onclick="caseattachmenteditbutton({{ $CC_DOCATTCHID }})" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="right" title="Kemaskini">
//                <i class="fa fa-pencil"></i></a>
//                {!! Form::open(["url" => "admin-case-doc/$CC_CASEID/$CC_DOCATTCHID", "method" => "DELETE", "style"=>"display:inline"]) !!}
//                {!! Form::button("<i class=\'fa fa-trash\'></i>", ["type" => "submit", "class" => "btn btn-danger btn-xs", "data-toggle"=>"tooltip", "data-placement"=>"right", "title"=>"Hapus", "onclick" => "return confirm(\'Anda pasti untuk hapuskan rekod ini?\')"] ) !!}
//                {!! Form::close() !!}
//            ''
                return view('aduan.admin-case.attachmentactionbuttonws', compact('adminCaseDoc', 'mesej_id'))->render();
            })
            ->rawColumns(['CC_IMG_NAME', 'action'])
        ;
        return $datatables->make(true);
    }
    
    public function preview($id, $mesej_id)
    {
        $model = AdminCase::find($id);
        $mAdminCaseDoc = AdminCaseDoc::where(['CC_CASEID' => $id])->get();
        $mUser = User::find($model->CA_RCVBY);
        if ($mUser) {
            $RcvBy = $mUser->name;
        } else {
            $RcvBy = '';
        }
        $mesej_id = $mesej_id;
        return view('feedback.whatsapp.preview_aduanws.index', compact('model', 'mAdminCaseDoc', 'RcvBy', 'mesej_id'));
    }

    public function submit(Request $Request, $id)
    {
        $mAdminCase = AdminCase::find($id);
        if ($mAdminCase->CA_INVSTS == '10') {
            if ($mAdminCase->CA_RCVTYP == 'S37') {
                $rule = '000';
            } else {
                $rule = '0';
            }
            $mAdminCase->CA_CASEID = RunnerRepository::generateAppNumber('X', date('y'), $rule); 
            $mAdminCase->CA_INVSTS = '1'; //Aduan Diterima
            // $mAdminCase->CA_RCVDT = Carbon::now();
            if ($mAdminCase->save()) {
                AdminCaseDoc::where('CC_CASEID', $id)->update(['CC_CASEID' => $mAdminCase->CA_CASEID]);
                AdminCaseDetail::where(['CD_CASEID' => $id, 'CD_CURSTS' => '1'])->update(['CD_CURSTS' => '0']);
                AdminCaseDetail::where('CD_CASEID', $id)->update(['CD_CASEID' => $mAdminCase->CA_CASEID]);
                $date = date('YmdHis');
                $userid = Auth::user()->id;
                $mSuratPublic = Letter::where(['letter_type' => '01', 'letter_code' => $mAdminCase->CA_INVSTS])->first();
                $ContentSuratPublic = $mSuratPublic->header . $mSuratPublic->body . $mSuratPublic->footer;

                if ($mAdminCase->CA_STATECD != '') {
                    $StateNm = DB::table('sys_ref')->select('descr')->where(['cat' => '17', 'code' => $mAdminCase->CA_STATECD])->first();
                    if (!$StateNm) {
                        $CA_STATECD = $mAdminCase->CA_STATECD;
                    } else {
                        $CA_STATECD = $StateNm->descr;
                    }
                } else {
                    $CA_STATECD = '';
                }
                if ($mAdminCase->CA_DISTCD != '') {
                    $DestrictNm = DB::table('sys_ref')->select('descr')->where(['cat' => '18', 'code' => $mAdminCase->CA_DISTCD])->first();
                    if (!$DestrictNm) {
                        $CA_DISTCD = $mAdminCase->CA_DISTCD;
                    } else {
                        $CA_DISTCD = $DestrictNm->descr;
                    }
                } else {
                    $CA_DISTCD = '';
                }
                $patterns[1] = "#NAMAPENGADU#";
                $patterns[2] = "#ALAMATPENGADU#";
                $patterns[3] = "#POSKODPENGADU#";
                $patterns[4] = "#DAERAHPENGADU#";
                $patterns[5] = "#NEGERIPENGADU#";
                $patterns[6] = "#NOADUAN#";
                $patterns[7] = "#TARIKH#";
                $patterns[8] = "#MASA#";
                $replacements[1] = $mAdminCase->CA_NAME;
                $replacements[2] = $mAdminCase->CA_ADDR != '' ? $mAdminCase->CA_ADDR : '';
                $replacements[3] = $mAdminCase->CA_POSCD != '' ? $mAdminCase->CA_POSCD : '';
                $replacements[4] = $CA_DISTCD;
                $replacements[5] = $CA_STATECD;
                $replacements[6] = $mAdminCase->CA_CASEID;
                $replacements[7] = date('d/m/Y', strtotime($mAdminCase->CA_RCVDT));
                $replacements[8] = date('h:i A', strtotime($mAdminCase->CA_RCVDT));

                $ContentReplace = preg_replace($patterns, $replacements, urldecode($ContentSuratPublic));
                $arr_rep = array("#", "#");
                $ContentFinal = str_replace($arr_rep, "", $ContentReplace);
                $pdf = PDF::loadHTML($ContentFinal); // Generate PDF from HTML


                $filename = $userid . '_' . $mAdminCase->CA_CASEID . '_' . $date . '.pdf';
                Storage::disk('letter')->put($filename, $pdf->output()); // Store PDF to storage

                $mAttachment = new Attachment();
                $mAttachment->doc_title = $mSuratPublic->title;
                $mAttachment->file_name = $mSuratPublic->title;
                $mAttachment->file_name_sys = $filename;
                if ($mAttachment->save()) {
                    $mAdminCaseDetail = new AdminCaseDetail();
                    $mAdminCaseDetail->fill([
                        'CD_CASEID' => $mAdminCase->CA_CASEID,
                        'CD_TYPE' => 'D',
                        'CD_ACTTYPE' => 'NEW',
                        'CD_INVSTS' => '1',
                        'CD_CASESTS' => '1',
                        'CD_CURSTS' => '1',
                        'CD_DOCATTCHID_PUBLIC' => $mAttachment->id,
                    ]);
                    if ($mAdminCaseDetail->save()) {
                        if ($mAdminCase->CA_EMAIL != '') {
//                            Mail::to($mAdminCase->CA_EMAIL)->queue(new AduanTerimaAdmin($mAdminCase)); // Send pakai queue
                            Mail::to($mAdminCase->CA_EMAIL)->send(new AduanTerimaAdmin($mAdminCase)); // Send biasa
                        }

                        // For feedback module usage.
                        // Send template when data is successfully submitted
                        if (in_array($mAdminCase->CA_RCVTYP, ['S37', 'S38'])) { // S37 - whatsapp; S38 - Telegram
                            $message = 'Aduan anda telah didaftarkan ke dalam Sistem e-Aduan KPDNHEP.
No. Aduan: *' . $mAdminCase->CA_CASEID . '*

Semakan Aduan boleh dibuat melalui:
a) Portal eAduan https://eaduan.kpdnhep.gov.my 
b) Aplikasi Ez ADU KPDNHEP (Android dan IOS)
c) Call Center : 1800 – 886 - 800
d) Emel ke e-aduan@kpdnhep.gov.my 

**Pendaftaran menggunakan Nama dan No. K/P diperlukan untuk semakan melalui Aplikasi Ez ADU.

Sekian, terima kasih
KPDNHEP';
                            // if ($mAdminCase->CA_RCVTYP == 'S37') {
                            //     WaboxappRepository::send($mAdminCase->CA_TELNO, $message);
                            // }

                            if ($mAdminCase->CA_RCVTYP == 'S38') {
                                $feed_telegram = FeedTelegram::find($mAdminCase->feedback_module_id);
                                TelegramRepository::sendMessageToReceiver($feed_telegram->user_id, $message);
                            }
                        }
                        // if whatsapp then send the case number to user
                        $Request->session()->flash(
                            'success', 'Aduan anda telah diterima. No. Aduan: ' . $mAdminCase->CA_CASEID . '.'
                        );
//                        return redirect()->route('admin-case.index');
                    }
                }

            }
        } else {
            $Request->session()->flash(
                'warning', 'Harap maaf, Aduan anda telah <b>diterima</b>. <br />No. Aduan: ' . $mAdminCase->CA_CASEID
            );
        }

        $mesej_id = $Request->mesej_id;
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$mesej_id/messages";

		$ch = curl_init($url);
		$jsonData = array(
			"message_text" => "Aduan anda telah diterima. No. Aduan: $mAdminCase->CA_CASEID",
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/" . $mesej_id . "/officer";
		
		$ch = curl_init($url);
		$jsonData = array(
			"officer_name" => "Selesai",
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

        return redirect()->route('admin-case.index');
    }

    public function AduanRoute($StateCd, $DistCd, $DeptCd, $RouteToHQ = false)
    {
        if ($DeptCd == 'BPGK') {
            if ($StateCd == '16') {
                $FindBrn = DB::table('sys_brn')
                    ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                    ->where('BR_STATECD', $StateCd)
                    ->where(DB::raw("LOCATE(CONCAT(',', '$DistCd' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                    ->where('BR_DEPTCD', 'BGK')
                    ->where('BR_STATUS', 1)
                    ->first();
            } else {
                $FindBrn = DB::table('sys_brn')
                    ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                    ->where('BR_STATECD', $StateCd)
                    ->where(DB::raw("LOCATE(CONCAT(',', '$DistCd' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                    ->where('BR_DEPTCD', $DeptCd)
                    ->where('BR_STATUS', 1)
                    ->first();
            }
            if ($RouteToHQ) {
                return 'WHQR5';
            } else {
                return $FindBrn->BR_BRNCD;
            }
        } else {
            $FindBrn = DB::table('sys_brn')
                ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                ->where('BR_STATECD', 16)
                ->where(DB::raw("LOCATE(CONCAT(',', '1601' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                ->where('BR_DEPTCD', $DeptCd)
                ->where('BR_STATUS', 1)
                ->first();
            return $FindBrn->BR_BRNCD;
        }
    }
	
	public function laporanbulanan()
    {
		return view('feedback.whatsapp.laporanbulanan.index');
    }
	
	public function caribulanan(Request $request)
    {
		$tahun = $request->tahun;
		if($tahun == "2020"){
			return view('feedback.whatsapp.jana_2020.index');
		}elseif($tahun == "2021"){
			return redirect('feedback.whatsapp.laporanbulanan.jana_2021');
		}
		
		return view('feedback.whatsapp.helpdesk.index');
    }
	
	/*public function helpdesk()
    {
        $laporanhelpdesks = Laporanhelpdesk::all();
        return view('feedback.whatsapp.helpdesk.index', [
            'laporanhelpdesks' => $laporanhelpdesks,
        ]);
    }*/
	
	public function newhelpdesk(Request $request){
	
		$url = "https://murai.io/api/dokumens";
        $datas = json_decode(file_get_contents($url), true);
        $datas = json_encode($datas);
        $datas = json_decode($datas, TRUE);

        $user = $request->user()->id;
		$role = UserAccess::where('user_id', $user)->first()->role_code;
		$jenis_user = $role;
		
        return view('feedback.whatsapp.helpdesk.index', [
            'datas' => $datas,
            'jenis_user' => $jenis_user
        ]);
	
	}

	public function update_keterangan(Request $request, $id){
	dd($id);
	
		$status = $request->status;
		$keterangan_vendor = $request->keterangan+vendor;
        	$url = "https://murai.io/api/dokumens/".$id;

		$ch = curl_init($url);
		$jsonData = array(
			"status" => $status,
			"keterangan_vendor" => $keterangan_vendor
		);
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

        	$datas = json_decode(file_get_contents($url), true);
        	$datas = json_encode($datas);
        	$datas = json_decode($try, TRUE);
		
        	return view('feedback.whatsapp.helpdesk.index', [
            		'datas' => $data
        	]);
	}
	
	public function newstorehelpdesk(Request $request){
	
		$isu = $request->isu;
		$tahap = $request->tahap;
		$keterangan = $request->keterangan;
		$dokumen = $request->dokumen;
		
		dd($dokumen);
		
        $url = "https://murai.io/api/dokumens";

		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = array(
			"isu" => $isu,
			"tahap" => $tahap,
			"keterangan" => $keterangan,
			"url" => $dokumen,
		);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		
		//hide response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//Execute the request
		$result = curl_exec($ch);
		
		// Close cURL resource
		curl_close($ch);

        $datas = json_decode(file_get_contents($url), true);
        $datas = json_encode($datas);
        $datas = json_decode($datas, TRUE);
		
        return view('feedback.whatsapp.helpdesk.index', [
            'datas' => $datas,
        ]);
	
	}
	
	public function storehelpdesk(Request $request){
	
		//upload file
		dd($request->all());
		$filePath = $request->file('dokumen')->store('whatsapp');
        $date = date('Ymdhis');
        $fileName = time() . '_' . $request->file('dokumen')->getClientOriginalName();
		$extension = $request->file('dokumen')->getClientOriginalExtension();
		$saiz = $request->file('dokumen')->getSize();

        $uploadPath = 'public';
        $file->store($fileName);

        $laporanhelpdesk = new laporanhelpdesk;
		
        $laporanhelpdesk->bentuk = $extension;
		$laporanhelpdesk->saiz = $saiz;
		$laporanhelpdesk->nama_fail = time() . '_' . $request->file('dokumen')->getClientOriginalName();
		$laporanhelpdesk->laluan_fail = $filePath;
		
		//validator upload
		$request->validate(
            [
                'dokumen' => 'required|mimes:jpg,jpeg,pdf|max:2048'
            ],
            [
                'dokumen.required' => 'Sila penuhkan butiran tersebut',
                'dokumen.mimes' => 'Lampiran hendaklah dalam bentuk jpg, jpeg, atau pdf'
            ]
        );
		
		$laporanhelpdesk->save();

        // $extension = $request->file('dokumen')->getClientOriginalExtension();

        $laporanhelpdesk = new laporanhelpdesk;

        $laporanhelpdesk->isu = $request->isu;
        $laporanhelpdesk->tahap = $request->tahap;
        $laporanhelpdesk->keterangan = $request->keterangan;
        $laporanhelpdesk->status = "Baru";
        $laporanhelpdesk->keterangan_vendor = $request->keterangan_vendor;

        $rules = [
            'isu' => 'required',
            'tahap' => 'required',
            'keterangan' => 'required',
        ];

        $messages = [
            'isu.required' => 'Sila isi nama isu',
            'tahap.rquired' => 'Sila pilih tahap isu tersebut',
            'keterangan.required' => 'Sila isi maklumat keterangan',
        ];

        Validator::make($request->input(), $rules, $messages)->validate();
        //$laporanhelpdesk->save();

        if ($request->file('dokumen')) {
            $fileName = time() . '_' . $request->file('dokumen')->getClientOriginalName();
            $filePath = $request->file('dokumen')->store('najhan');
            $extension = $request->file('dokumen')->getClientOriginalExtension();

            $saiz = $request->file('dokumen')->getSize();
            if ($saiz) {
                $saiz = $saiz / 1000;
            } else {
                $saiz = rand(500, 1999);
            }
            if ($saiz > 2000) {
                echo "<script>alert('Saiz lampiran tidak boleh melebihi 2mb.');</script>";
            } else {
                $laporanhelpdesk->bentuk = $extension;
                $laporanhelpdesk->saiz = $saiz;
                $laporanhelpdesk->nama_fail = time() . '_' . $request->file('dokumen')->getClientOriginalName();
                $laporanhelpdesk->laluan_fail = $filePath;

                $laporanhelpdesk->save();

                return view('feedback.whatsapp.helpdesk.index');
            }
        } else {
            echo "<script>alert('Sila masukkan lampiran berbentuk pdf dan saiz tidak melebihi 2mb.');</script>";
        }
        return view('feedback.whatsapp.helpdesk.index');
	
	}
	
	// public function dokumenfasa()
    // {
	// 	$dokumenfasas = Dokumenfasa::all();
    //     return view('feedback.whatsapp.dokumenfasa.index', [
    //         'dokumenfasas' => $dokumenfasas,
    //     ]);
    // }

    public function newdokumenfasa(){
	
		$url = "https://murai.io/api/dokumens";
        $datas = json_decode(file_get_contents($url), true);
        $datas = json_encode($datas);
        $datas = json_decode($datas, TRUE);
		
        return view('feedback.whatsapp.dokumenfasa.index', [
            'datas' => $datas,
        ]);
	
	}
	
	public function storedokumen(Request $request){
	dd($request);
		$request->validate(
            [
                'dokumen' => 'required|mimes:jpg,jpeg,pdf|max:2048'
            ],
            [
                'dokumen.required' => 'Sila penuhkan butiran tersebut',
                'dokumen.mimes' => 'Lampiran hendaklah dalam bentuk jpg, jpeg, atau pdf'
            ]
        );

        $dokumenfasa = new Dokumenfasa;

        $dokumenfasa->nama_dok = $request->nama_dok;
        $dokumenfasa->fasa = $request->fasa;
        $dokumenfasa->catatan = $request->catatan;

        $rules = [
            'nama_dok' => 'required',
            'fasa' => 'required',
            'catatan' => 'required',
        ];

        $messages = [
            'nama_dok.required' => 'Sila isi ruang nama dokumen tersebut',
            'catatan.required' => 'Sila berikan catatan untuk dokumen tersebut',
        ];

        Validator::make($request->input(), $rules, $messages)->validate();

        if ($request->file()) {
            $fileName = time() . '_' . $request->file('dokumen')->getClientOriginalName();
            $filePath = Storage::putFile('najhan', $request->file('dokumen'), 'public');#$request->file('file')->storeAs('najhan', $fileName, 'public');
            $extension = $request->file('dokumen')->getClientOriginalExtension();
            
            if ($extension == "pdf") {
                $saiz = $request->file('dokumen')->getSize();
                if($saiz) {
                    $saiz = $saiz / 1000;
                } else {
                    $saiz = rand(500,2000);
                }
                if ($saiz > 2000) {
                    echo "<script>alert('Saiz lampiran tidak boleh melebihi 2mb.');</script>";
                } else {
                    $dokumenfasa->saiz = $request->file('dokumen')->getSize();
                    $dokumenfasa->nama_fail = time() . '_' . $request->file('dokumen')->getClientOriginalName();
                    $dokumenfasa->laluan_fail = $filePath;
                    $dokumenfasa->save();
                }
            } else {
                echo "<script>alert('Sila masukkan lampiran berbentuk pdf.');</script>";
            }
        } else {
            echo "<script>alert('Sila muatnaik dokumen berbentuk pdf dan saiz tidak melebihi 2mb.');</script>";
        }
        return view('feedback.whatsapp.dokumenfasa.index');
	
	}
	

    public function index()
    {
        return view('feedback.whatsapp.new.index');
    }

    // API NAJHAN
    public function getByAduanNo($req) {


        $noaduan= $req;
        $mPublicCase = DB::table('case_info')
                ->where(['CA_CASEID' => $noaduan])
                ->first();

        //dd($mPublicCase);
                //dd(gettype($mPublicCase));
        $status = $mPublicCase->CA_INVSTS;



        return response()->json(['data' => $status]);
    }
}