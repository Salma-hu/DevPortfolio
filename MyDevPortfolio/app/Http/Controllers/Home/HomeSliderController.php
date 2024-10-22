<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use Intervention\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;


class HomeSliderController extends Controller
{

    public function HomeSlider(){

        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all',compact('homeslide'));

    } // End Method 


    public function UpdateSlider(Request $request){

        $slide_id = $request->id;

        if ($request->file('home_slide')) {
            // $image = $request->file('home_slide');
            // $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            // Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);
            // $save_url = 'upload/home_slide/'.$name_gen;

            $manager = new ImageManager(new Driver());
            $img_name = hexdec(uniqid()).'.'.$request->file('home_slide')->getClientOriginalExtension();
            $img = $manager->read($request->file('home_slide'));
            $img->resize(636,852);
            $img->toJpeg(80)->save(base_path('public/upload/home_slide/'.$img_name));
            $save_url = 'upload/home_slide/'.$img_name;

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slide' => $save_url,

            ]); 
            $notification = array(
            'message' => 'Home Slide Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,  

            ]); 
            $notification = array(
            'message' => 'Home Slide Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } // end Else

     } // End Method 

}
