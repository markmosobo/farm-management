<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    public function postsProfile()
    {
        $user = auth('api')->user();
        $profileposts = Post::all()->where('author_id',$user->id)->count();
        $posts = $profileposts;
        return response()->json($posts);
    }

    public function postsView()
    {
        $user = auth('api')->user();
        $profilepostviews = Post::all()->where('author_id',$user->id)->sum('views');
        $views = $profilepostviews;
        return response()->json($views);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:6'
        ]);

        $currentPhoto = $user->photo;
        
        if($request->photo != $currentPhoto){
            $name = time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos
            ($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('images/profile/').$name);
            $request->merge(['photo' => $name]);
        
        //delete old photo from server
        $userPhoto = public_path('images/profile/').$currentPhoto;
        if(file_exists($userPhoto)){
            @unlink($userPhoto);
        }    
        }
        //hash new password
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => 'success'];
    }    
}
