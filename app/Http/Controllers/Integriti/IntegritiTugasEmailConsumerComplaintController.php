<?php

namespace App\Http\Controllers\Integriti;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrity\StoreIntegrityEmailConsumerComplaintRequest;
use App\Mail\Integrity\IntegrityEmailToConsumerComplaint;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Send email from integrity to consumer complaint.
 *
 * Class IntegritiTugasEmailConsumerComplaintController
 * @package App\Http\Controllers\Integriti
 */
class IntegritiTugasEmailConsumerComplaintController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('integrititugas.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreIntegrityEmailConsumerComplaintRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntegrityEmailConsumerComplaintRequest $request)
    {
        $user = auth()->user();

        $input = $request->all();

        try {
            // Send normal email
            Mail::send(new IntegrityEmailToConsumerComplaint($input, $user));
        } catch (Exception $ex) {
            return redirect()->route('integrititugas.index')
                ->with('alert', 'Emel gagal dihantar.<br />' . $ex->getMessage());
        }

        return redirect()->route('integrititugas.index')
            ->with('success', 'E-mel telah berjaya dihantar.');
    }
}
