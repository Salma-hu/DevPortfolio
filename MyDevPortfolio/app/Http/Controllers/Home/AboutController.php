<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Intervention\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AboutController extends Controller
{
    public function AboutPage(){

        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));

    } // End Method 


    public function UpdateAbout(Request $request){

        $about_id = $request->id;

        if ($request->file('about_image')) {

            $manager = new ImageManager(new Driver());
            $img_name = hexdec(uniqid()).'.'.$request->file('about_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('about_image'));
            $img->resize(523,605);
            $img->toJpeg(80)->save(base_path('public/upload/home_about/'.$img_name));
            $save_url = 'upload/home_about/'.$img_name;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,

            ]); 
            $notification = array(
            'message' => 'About Page Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

            ]); 
            $notification = array(
            'message' => 'About Page Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } // end Else

    } // End Method 

    
    
     public function HomeAbout(){

        $aboutpage = About::find(1);
        return view('frontend.about_page',compact('aboutpage'));

     }// End Method 


     public function AboutMultiImage(){

        return view('admin.about_page.multimage');


     }// End Method 



}
