<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $response = Http::get($url);
        $biliks = $response->json();
        $biliks = json_encode($biliks);
        $biliks = json_decode($biliks, TRUE)['rooms'];
        // dd($response['rooms']);

        return view('tugasans', [
            'biliks' => $biliks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tugasan  $tugasan
     * @return \Illuminate\Http\Response
     */
    public function show(Tugasan $tugasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tugasan  $tugasan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tugasan $tugasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugasan  $tugasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tugasan $tugasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tugasan  $tugasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugasan $tugasan)
    {
        //
    }
    public function hantar($id)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $response = Http::get($url);
        $mesejs = $response->json();
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        // dd($mesejs[87]['message_text']);

        $room = json_decode($try, TRUE)['room'];
        return view('mesej', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }

    public function hantarrr(Request $request, $id)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";

        $hantar = $request->hantar;
        $send = Http::post($url, [
            "message_text" => $hantar,
        ]);

        // if($send->successful()) {
        //     $url = '/hantar/{{$id}}';
        //     return redirect($url);
        // }

        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $response = Http::get($url);
        $mesejs = $response->json();
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        $room = json_decode($try, TRUE)['room'];

        return view('mesej', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }
    public function caritugasan(Request $request)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms";
        $phone = $request->phone;
        $name = $request->name;
        $officer_name = $request->officer_name;
        // dd($name, $phone);
        if ($phone != null && $name == null && $officer_name == null) {
            $response = Http::post($url, [
                "phone" => $phone,
            ]);
        } else if ($phone == null && $name != null && $officer_name == null) {
            $response = Http::post($url, [
                "name" => $name
            ]);
        } else if ($phone == null && $name == null && $officer_name != null) {
            $response = Http::post($url, [
                "officer_name" => $officer_name
            ]);
        } else {
            return redirect('/tugasans');
        }
        $biliks = $response->json();
        $biliks = json_encode($biliks);
        $biliks = json_decode($biliks, TRUE)['rooms'];

        return view('tugasans', [
            'biliks' => $biliks,
        ]);
    }

    public function potong($id, $index)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $response = Http::get($url);
        $mesejs = $response->json();
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        // dd($mesejs[$index]['message_text']);

        $long_string = $mesejs[$index]['message_text'];
        $array_string = explode("\n", $long_string);
        echo '<br/>';
        // dd($array_string);
        
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

        // dd($nama, $ic, $alamat, $telefon, $email);
        return view('/admin-case.create', [
            'nama' => $nama,
            'ic' => $ic,
            'alamat' => $alamat,
            'telefon' => $telefon,
            'email' => $email
        ]);
    }

    public function testing($id,Request $request)
    {
        $url = "https://murai.io/api/whatsapp/numbers/601154212526/rooms/$id/messages";
        $msgid = $request->msgid;
        $response = Http::post($url, [
            "id" => $msgid,
        ]);
        $mesejs = $response->json();
        // dd($mesejs);
        $try = json_encode($mesejs);
        $mesejs = json_decode($try, TRUE)['messages'];
        $room = json_decode($try, TRUE)['room'];
        return view('mesej', [
            'mesejs' => $mesejs,
            'room' => $room
        ]);
    }
}
