<?php

namespace Modules\IrCity\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\IrCity\Entities\ProvinceCity;

class IrCityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $items = ProvinceCity::whereNull('parent_id')->get();

        return view('ircity::index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ircity::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(ProvinceCity $city)
    {
        $items = $city->children;

        return view('ircity::show', compact('items', 'city'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ProvinceCity $city)
    {
        $provinces = ProvinceCity::whereNull('parent_id')->get();

        return view('ircity::edit', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ProvinceCity $city)
    {
        try {
            $city->parent_id = $request->parent_id;
            $city->name = $request->name;
            $city->save();

            if ($request->parent_id){
                return redirect()->route('cities.show', $request->parent_id)->with('flash_message', 'بروزرسانی با موفقیت انجام شد');
            }else{
                return redirect()->route('cities.index')->with('flash_message', 'بروزرسانی با موفقیت انجام شد');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ProvinceCity $city)
    {
        try {
            $city->delete();

            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }
}
