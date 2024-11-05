<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\MultiImage;
use Intervention\Image\Facades\Image;
use Intervention\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function AboutPage(){

        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));

    } // End Method 


    public function UpdateAbout(Request $request){

        $about_id = $request->id;

        if ($request->file('about_image')) {

            // $manager = new ImageManager(new Driver());
            // $img_name = hexdec(uniqid()).'.'.$request->file('about_image')->getClientOriginalExtension();
            // $img = $manager->read($request->file('about_image'));
            // $img->resize(523,605);
            // $img->toJpeg(80)->save(base_path('public/upload/home_about/'.$img_name));
            // $save_url = 'upload/home_about/'.$img_name;

            // About::findOrFail($about_id)->update([
            //     'title' => $request->title,
            //     'short_title' => $request->short_title,
            //     'short_description' => $request->short_description,
            //     'long_description' => $request->long_description,
            //     'about_image' => $save_url,

            // ]); 
            // $notification = array(
            //     'message' => 'About Page Updated with Image Successfully', 
            //     'alert-type' => 'success'
            // );

            // return redirect()->back()->with($notification);


            /* *** */

            // Validate the request inputs
            $request->validate([
                'title' => 'required',
                'short_title' => 'required',
                'short_description' => 'required',
                'long_description' => 'required',
                'about_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Process and store the image
            $imageName = time().'.'.$request->about_image->extension();
            $request->about_image->move(public_path('upload/home_about'), $imageName);
            $save_url = 'upload/home_about/'.$imageName;

            // Update the database record
            $about = About::findOrFail($request->id);
            $about->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            // Notification message
            $notification = [
                'message' => 'About Page Updated with Image Successfully',
                'alert-type' => 'success'
            ];

            // Redirect back with a success message
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


    public function StoreMultiImage(Request $request){

        
       // Valider que le champ contient au moins une image
        $request->validate([
            'multi_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Supprimer toutes les anciennes images
        $oldImages = MultiImage::all();
        // foreach ($oldImages as $oldImage) {
        //     if (file_exists(public_path($oldImage->multi_image))) {
        //         unlink(public_path($oldImage->multi_image));
        //     }
        //     $oldImage->delete(); // Supprimer l'entrée dans la base de données
        // }

        // Ajouter les nouvelles images
        if ($request->hasFile('multi_image')) {
            foreach ($request->file('multi_image') as $image) {
                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/multi'), $imageName);
                $saveUrl = 'upload/multi/' . $imageName;

                MultiImage::insert([

                    'multi_image' => $saveUrl,
                    'created_at' => Carbon::now()

                ]); 
            }
        }

        $notification = array(
            'message' => 'Multi Image Inserted Successfully', 
            'alert-type' => 'success'
        );

        // return redirect()->route('all.multi.image')->with($notification);
        return redirect()->back()->with($notification);

    }// End Method


    public function AllMultiImage(){

        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));

     }// End Method 


    
     public function EditMultiImage($id){

        $multiImage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image',compact('multiImage'));

    }// End Method 

    public function UpdateMultiImage(Request $request){

        $multi_image_id = $request->id;

        // Validate the request inputs
        $request->validate([
            'multi_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        

        if ($request->file('multi_image')) {

            // Process and store the image
            $imageName = time().'.'.$request->multi_image->extension();
            $request->multi_image->move(public_path('upload/multi'), $imageName);
            $save_url = 'upload/multi/'.$imageName;

            MultiImage::findOrFail($multi_image_id)->update([
                
                'multi_image' => $save_url,

            ]); 

            $notification = array(
                'message' => 'Multi Image Updated Successfully', 
                'alert-type' => 'success'
            );

            return redirect()->route('all.multi.image')->with($notification);

        }

    }// End Method 

    public function DeleteMultiImage($id){

        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



    }





}
