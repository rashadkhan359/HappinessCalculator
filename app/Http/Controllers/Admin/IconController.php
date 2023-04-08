<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Icon as ModelsIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $icons=ModelsIcon::all();
        return view('admin.icon.index', compact('icons'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.icon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'image' => 'required',
        ])->validate();
            
        if ($request->has('image')) {
            $image_path = $request->file('image')->store('icons_imgs', 'public');
            $image = explode('/', $image_path);
        }

        $icon=new ModelsIcon();
        $icon->name=$request->name;
        $icon->path= 'icons_imgs/'.$image[1];
        $icon->file_name=$image_path;
        $icon->save();

        return redirect()->route('icon.index')->with('success','New icons added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsIcon $icon)
    {
        $icon->delete();
        return redirect()->route('icon.index')->with('success','Icon Deleted Successfully');
    }
}
