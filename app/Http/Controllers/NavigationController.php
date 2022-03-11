<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    

    public $navigation;

    public function __construct(Navigation $navigation){

        $this->navigation = $navigation;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navigations = $this->navigation->whereNull('parent_id')->first()->getDescendants();
        return response()->view('navigations.index',compact('navigations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigations = $this->navigation->all();
        return response()->view('navigations.create',compact('navigations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =request()->all();
        $data['name']=strtolower(str_replace(" ","_",request('display_name')));
        $this->navigation->create($data);
        return redirect()->route('navigation.index')->withMessage('Navigation Item added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function show(Navigation $navigation)
    {
        $navitems = $navigation->descendants()->get();
        foreach ($navitems as $nav){
            $navBar[] = $nav->getItem();
        }
        return $navBar;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $navigation)
    {
        $navigations = $this->navigation->all();
        return response()->view('navigations.edit',compact('navigation','navigations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Navigation $navigation)
    {
         $data =request()->all();
        $data['name']=strtolower(str_replace(" ","_",request('display_name')));
        $navigation->update($data);
        return redirect()->route('navigation.index')->withMessage('Navigation Item Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $navigation)
    {
        $navigation->delete();
        return redirect()->route('navigation.index')->withMessage('Navigation item deleted');
    }
}
