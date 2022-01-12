<?php

namespace App\Http\Controllers\Ref\Integrity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\Integrity\StoreRefIntegrityCategoryRequest;
use App\Http\Requests\Ref\Integrity\UpdateRefIntegrityCategoryRequest;
use App\Ref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RefIntegrityCategoryController extends Controller
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
        $data['headings'] = [
            'Bil.', 'Kod', 'Penerangan', 'Penerangan Inggeris', 'Susunan', 'Status', ''
        ];
        $data['refIntegrityCategories'] = Ref::where('cat', 1344)->paginate(10);
        foreach($data['refIntegrityCategories'] as $row) {
            $row->statusDescription = Ref::ShowStatus($row->status ?? '');
        }
        if (View::exists('ref.integrity.category.index')) {
            return view('ref.integrity.category.index', ['data' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['statuses'] = ['1' => 'Aktif', '0' => 'Tidak Aktif'];
        if (View::exists('ref.integrity.category.create')) {
            return view('ref.integrity.category.create', ['data' => $data]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefIntegrityCategoryRequest $request)
    {
        $input = $request->all();

        $refIntegrityCategory = new Ref;
        $refIntegrityCategory->code = $request->code;
        $refIntegrityCategory->descr = $request->descr;
        $refIntegrityCategory->descr_en = $request->descr_en;
        $refIntegrityCategory->sort = $request->sort;
        $refIntegrityCategory->status = $request->status;
        $refIntegrityCategory->cat = '1344';
        $refIntegrityCategory->save();

        return redirect(route('ref.integrity.categories.index'))
            ->with('success', 'Maklumat Kategori Aduan Integriti telah <b>berjaya</b> disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('ref.integrity.categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['refIntegrityCategory'] = Ref::find($id);
        if (empty($data['refIntegrityCategory']) || $data['refIntegrityCategory']->cat !== '1344') {
            return redirect(route('ref.integrity.categories.index'))
                ->with('alert', 'Maklumat Kategori Aduan Integriti tidak dijumpai.');
        }

        $data['statuses'] = ['1' => 'Aktif', '0' => 'Tidak Aktif'];
        if (View::exists('ref.integrity.category.index')) {
            return view('ref.integrity.category.edit', ['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRefIntegrityCategoryRequest $request, $id)
    {
        $refIntegrityCategory = Ref::find($id);
        if (empty($refIntegrityCategory) || $refIntegrityCategory->cat !== '1344') {
            return redirect(route('ref.integrity.categories.index'))
                ->with('alert', 'Maklumat Kategori Aduan Integriti tidak dijumpai.');
        }
        $refIntegrityCategory->code = $request->code;
        $refIntegrityCategory->descr = $request->descr;
        $refIntegrityCategory->descr_en = $request->descr_en;
        $refIntegrityCategory->sort = $request->sort;
        $refIntegrityCategory->status = $request->status;
        $refIntegrityCategory->cat = '1344';
        $refIntegrityCategory->save();

        return redirect(route('ref.integrity.categories.index'))
            ->with('success', 'Maklumat Kategori Aduan Integriti telah <b>berjaya</b> dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
        
    // }
}
