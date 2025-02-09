<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCountryRequest;
use App\Http\Requests\Admin\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Countries';
        $SubTitle = 'Add';
        return view('Admin._countries.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function countries()
    {
        $records = Country::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Countries';
        $SubTitle = 'Add';
        return view('Admin._countries.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            //upload new file
            if ($request->file('flag')) {
                $flag = UploadFile::UploadSinglelFile($request->file('flag'), 'countries');
            } else {
                $flag = null;
            }

            Country::create([
                'flag' => $flag,
                'en' => [
                    'name' => $input['name_en'],
                    'alt' => $input['alt_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                    'alt' => $input['alt_ar'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Country has been created Succssfuly');
            return redirect()->route('countries.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add' . $exception->getMessage());
            return redirect()->route('countries.index');

        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Countries';
        $SubTitle = 'Add';
        $country = Country::findOrFail($id);
        return view('Admin._countries.edit', compact('country', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateCountryRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {
            $country->translate('en')->name = $input['name_en'];
            $country->translate('ar')->name = $input['name_ar'];
            $country->translate('en')->alt = $input['alt_en'];
            $country->translate('ar')->alt = $input['alt_ar'];
            //upload new file
            if ($request->file('flag')) {
                if ($country->flag)
                //Remove old file
                {
                    UploadFile::RemoveFile($country->flag);
                }

                $country->flag = UploadFile::UploadSinglelFile($request->file('flag'), 'countries');
            }
            $country->save();
            DB::commit();
            session()->flash('_added', 'Country data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        //Remove old file
        if ($country->flag) {
            UploadFile::RemoveFile($country->flag);
        }
        $country->delete();
        return response()->json([], 200);
    }
}
