<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class PortfolioController extends Controller
{
    public function AllPortfolio(){

        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all',compact('portfolio'));

    }// End Method
    
    public function AddPortfolio(){

        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_add');

    }// End Method


    public function StorePortfolio(Request $request){

        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required',

        ],[

            'portfolio_name.required' => 'Portfolio Name is Required',
            'portfolio_title.required' => 'Portfolio Titile is Required',
        ]);

        $imageName = time().'.'.$request->portfolio_image->extension();
        $request->portfolio_image->move(public_path('upload/portfolio'), $imageName);
        $save_url = 'upload/portfolio/'.$imageName;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Portfolio Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

    }// End Method


    public function EditPortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit',compact('portfolio'));
    }// End Method

    public function UpdatePortfolio(Request $request){

        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')) {

            $image = $request->file('portfolio_image');
            
            $manager = new ImageManager(new Driver());
            $img_name = hexdec(uniqid()).'.'.$request->file('portfolio_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('portfolio_image'));
            $img->resize(1020,519);
            $img->toJpeg(80)->save(base_path('public/upload/portfolio/'.$img_name));
            $save_url = 'upload/portfolio/'.$img_name;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,

            ]); 
            $notification = array(
            'message' => 'Portfolio Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

        } else{

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                 

            ]); 
            $notification = array(
            'message' => 'Portfolio Updated without Image Successfully', 
            'alert-type' => 'success'
        );

       return redirect()->route('all.portfolio')->with($notification);

        }

     } // End Method 


    public function DeletePortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Portfolio Image Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);       

    }// End Method 


    public function PortfolioDetails($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.protfolio_details',compact('portfolio'));
    } // End Method 


    public function HomePortfolio(){

      $portfolio = Portfolio::latest()->get();
      return view('frontend.portfolio',compact('portfolio'));
      
    } // End Method 





}
