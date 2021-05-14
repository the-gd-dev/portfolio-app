<?php
namespace App\Http\Traits;

use App\Models\Portfolio;
use App\Models\PortfolioImages;
use Illuminate\Http\Request;
trait PortfolioImagesTrait
{
    public function portfolioImagesStore($data, $portfolio_id){
        $user_id = auth()->user()->id;
        $this->deleteOldFiles($portfolio_id);
        if(isset($data)){
            foreach ($data as $key => $image) {
                $image->portfolio_id =  $portfolio_id;
                $image->user_id = $user_id;
                $pi  = PortfolioImages::create((array) $image);
                if($key == 0){
                    Portfolio::find($portfolio_id)->update(['portfolio_cover' => $pi->id]);
                }
            }
        }
    }

    public function deleteOldFiles($portfolio_id){
        $user_id = auth()->user()->id;
        Portfolio::find($portfolio_id)->update(['portfolio_cover' => null]);
        $imgs = PortfolioImages::where('user_id', $user_id)->where('portfolio_id', $portfolio_id);
        if($imgs->get()->count() > 0){
            $imgs->each(function($img)use($user_id){
                $path = public_path().'/storage/portfolio-images/'.$user_id.'/'.$img->name;
                if(file_exists($path)){
                    unlink($path);
                }
            });
        }
        return $imgs->delete();
    }

    public function portfolioImagesSorting($sortingData, $portfolio_id)
    {   
        $user_id = auth()->user()->id;
        foreach ($sortingData as  $data) {
            $PortfolioImage = PortfolioImages::find( $data['id']);
            if(isset($PortfolioImage)){
                $PortfolioImage->update(['order' => $data['order']]);
            }
        }
        $imgs = PortfolioImages::where('user_id', $user_id)->where('portfolio_id', $portfolio_id)->orderBy('order')->get();
        $response = $this->successResponse(['images' => $imgs, 'base_url' => asset("storage/portfolio-images/$user_id/")], '!! Updated !!');
        return response()->json($response, 200);
    }

    public function portfolioImages(Request $request)
    {
        $userId = auth()->user()->id;
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'image'
        ]);
        $data = [];
        if($request->hasfile('images'))
        {
            if(count($request->file('images')) > 10){
                return response()->json(['message' => "You can't upload more then 10 files. Please try again."], 422);
            }
            foreach($request->file('images') as $file)
            {
                $name = "PORTFOLIO-IMAGE-".date('Y-m-d').'-'.rand(9999, 999999999).'.'.$file->extension();
                $file->storeAs("public/portfolio-images/$userId/", $name);  
                list($height , $width ) = getimagesize( $file);
                array_push($data, [
                    'name' => $name,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'height' => $height,
                    'width' => $width,
                ]);
            }
        }

        return response()->json($this->successResponse(['images' => $data , 'base_url' => asset("storage/portfolio-images/$userId/")], 'Files Uploaded Successfully.'),200);
    }
}