<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Icon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $activities=Activity::all();
        
        return view('admin.activity.index',compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['category']=Category::all();
        $data['icons']=Icon::all();
        return view('admin.activity.create',compact('data'));
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
            'category' => ['required', 'integer'],
            'icons' => ['required', 'integer'],
            'colorcode' => ['required', 'string'],
        ])->validate();

        $activity =new Activity;
        $activity->name=$request->name;
        $activity->category_id=$request->category;
        $activity->icon_id= $request->icons;
        $activity->color_code=$request->colorcode;
        $activity->save();
        return redirect()->route('activity.index')->with('success', 'New Activity added successfully!');
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
    public function edit(Activity $activity)
    {
        $activity['category'] = Category::all();
        $activity['icons'] = Icon::all();
        return view('admin.activity.edit',compact('activity'));
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
        $activity=Activity::find($id);
        $activity->name=$request->name;
        $activity->category_id=$request->category;
        $activity->icon_id= $request->icons;
        $activity->color_code=$request->colorcode;
        $activity->save();
        return redirect()->route('activity.index')->with('success', 'Activity updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity=Activity::find($id);
        $activity->delete();
        return redirect()->route('activity.index')->with('success', 'Activity deleted successfully!');
    }
}
