<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Thrailer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\VideoApproval;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ThrailerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thrailers = auth()->user()->thrailers()->get();

        return view('thrailers.index', compact('thrailers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thrailers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $preview_cost = null;
        $cover = null;
        $book_id = null;
        $event_id = null;
        $thrailer_id = null;
        $genre = null;
        $code = Str::random(8);
        // dd(request()->all());
        // dd($request->all());
        $validated = $this->validate($request, [
            "title" => "required",
            "cost" => "required",
            "cpy" => "required",
            "gem" => "required",
            "category" => "required",
            "desc" => "",
            "credit" => "",
            "author" => "required",
            "video" => "required",
            "age_restriction" => "required",
            'language'=>'required',
            'cover'=>'',
            'cpy'=>'',
            'preview_cost'=>''
        ]);
        //just set to null

        $path_cover = request()->cover->store('public/thrailers_cover');
        $arr_path_cover = explode('/', $path_cover);
        $end_path_cover = end($arr_path_cover);
        $cover = '/storage/thrailers_cover/'.$end_path_cover;

        if($request->category == 'trailer'){
            if($request->connect_id != null){
                $connect = $request->connect_id;
                $connect_array = explode('-', $connect);
                $connect_type = $connect_array[0];
                $connect_id = end($connect_array);

                if($connect_type == 'book'){
                    $book_id = $connect_id;
                }else {
                    $thrailer_id = $connect_id;
                }
            }
        }else {
            $genre = $request->genre;
            $event_id = request()->event_id;
            // if(!empty(request()->preview)){
            //     $preview_path = request()->preview->store('/public/previews');
            //     $arr_preview_path = explode('/', $preview_path);
            //     $end_preview = end($arr_preview_path);
            //     $preview = '/storage/previews/'.$end_preview;
            //     $preview_cost = request()->preview_cost ?? 0;
            // }
        }
        
        $video = auth()->user()->thrailers()->create([
            'title' => request()->title,
            'author' => request()->author,
            'video' => request()->video,
            'code' => $code,
            'event_id' => $event_id,
            'preview'=> $request->preview,
            'preview_cost'=> $request->preview_cost,
            'cover'=> $cover,
            'group_id'=> $request->group_id,
            'genre'=>$genre,
            'book_id' => $book_id,
            'thrailer_id'=>$thrailer_id,
            'desc'=>request()->desc,
            'category'=>request()->category,
            'credit'=>request()->credit,
            'age_restriction'=>request()->age_restriction,
            'language'=>request()->language,
            'gem'=>request()->gem,
            'cost'=>request()->cost,
            'cpy'=>now()
        ]);

        // Notification::send(Admin::get(), new VideoApproval($video));
        return redirect(route('thrailers.index').'?id='.$video->id)->with('success', 'Item stored successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thrailer $thrailer
     * @return \Illuminate\Http\Response
     */
    public function show(Thrailer $thrailer)
    {
        return view('thrailers.show', compact('thrailer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thrailer $thrailer
     * @return \Illuminate\Http\Response
     */
    public function edit(Thrailer $thrailer)
    {
        return view('thrailers.edit', compact('thrailer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thrailer $thrailer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thrailer $thrailer)
    {
        $validated = $this->validate($request, [
            'category'=>'',
            'genre'=>'',
            'type'=>'',
            'language'=>'',
            'lead_character'=>'',
            'lead_college'=>'',
            'blurb'=>'',
            'review_question_1'=>'',
            'review_question_2'=>'',
            'credit'=>'',
            'desc'=>'',
            'publish_date'=>'',
            'code'=>''
        ]);
        if(request()->has('code')){
            if( $validated['code'] == $thrailer->code){
                $validated['approved'] = date("Y/m/d");
            }else {
                return back()->withErrors('Invalid Code, please contact the Adminstrator');
            }
        }
        $thrailer->update($validated);
        return back()->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thrailer $thrailer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thrailer $thrailer)
    {
        request()->validate(['password'=>'required']);

        if(Hash::check(request()->password, auth()->user()->password )){
            // $arr_path = explode('/', $thrailer->video);
            // $end_path = end($arr_path);
            // Storage::delete('/public/thrailers/'.$end_path);
            $thrailer->delete();
        }else {
            return abort(401);
        }

        return redirect()->route('thrailers.index')->with('success', 'Item deleted successfully');
    }

    public function updateCover(Thrailer $thrailer){
        Storage::delete($thrailer->cover);
        $path_cover = request()->cover->store('public/thrailers_cover');
        $arr_path_cover = explode('/', $path_cover);
        $end_path_cover = end($arr_path_cover);
        $cover = '/storage/thrailers_cover/'.$end_path_cover;
        $thrailer->cover = $cover;
        $thrailer->save();
        return back()->withSuccess('Cover Updated!');
    }

    
}
