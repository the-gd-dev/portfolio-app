<?php

namespace App\Http\Traits;

use App\Models\Portfolio;
use App\Models\PortfolioImages;
use Illuminate\Http\Request;

trait PortfolioImagesTrait
{
    /**
     * Storing file names to resource
     * @param App\Models\Portfolio $portfolio_id
     * @var $data
     */
    public function portfolioImagesStore($data, $portfolio_id)
    {
        $user_id = auth()->user()->id;
        $this->deletePortfolioImages($portfolio_id);
        if (isset($data)) {
            foreach ($data as $key => $image) {
                $image->portfolio_id =  $portfolio_id;
                $image->user_id = $user_id;
                $pi  = PortfolioImages::create((array) $image);
                if ($key == 0) {
                    Portfolio::find($portfolio_id)->update(['portfolio_cover' => $pi->id]);
                }
            }
        }
        $this->cleanFolderGarbage($portfolio_id);
    }

    /**
     * deleting all files from directory (Not stored to database)
     * @param App\Models\Portfolio $portfolio_id
     */
    public function cleanFolderGarbage($portfolio_id)
    {
        $user_id = auth()->user()->id;
        $pubPath = '/storage/portfolio-images';
        $fileNames = preg_grep("~\.(jpg|png|jpeg|gif|svg)$~", scandir(public_path("$pubPath/$user_id")));
        $imgs   = PortfolioImages::where('user_id', $user_id)->where('portfolio_id', $portfolio_id)->pluck('name')->toArray();
        if(count($fileNames) > 0){
            $deleteTheseFiles  = array_diff($fileNames, $imgs);
            if (isset($deleteTheseFiles) && count($deleteTheseFiles) > 0) {
                foreach ($deleteTheseFiles as $f) {
                    $path = public_path("$pubPath/$user_id/$f");
                    if (file_exists($path)) {
                        unlink($path);
                    }
                };
            }
        }
    }

    /**
     * deleting all files from resource
     * @param App\Models\Portfolio $portfolio_id
     * @return App\Models\PortfolioImages::delete();
     */
    public function deletePortfolioImages($portfolio_id)
    {
        $user_id = auth()->user()->id;
        Portfolio::find($portfolio_id)->update(['portfolio_cover' => null]);
        $imgs   = PortfolioImages::where('user_id', $user_id)->where('portfolio_id', $portfolio_id);
        return $imgs->delete();
    }

    /**
     * Sorting the resources
     * @param  App\Models\Portfolio $portfolio_id
     * @var $sortingData
     * @return Array
     */
    public function portfolioImagesSorting($sortingData, $portfolio_id)
    {
        $user_id = auth()->user()->id;
        foreach ($sortingData as  $data) {
            $PortfolioImage = PortfolioImages::find($data['id']);
            if (isset($PortfolioImage)) {
                $PortfolioImage->update(['order' => $data['order']]);
            }
        }
        $imgs = PortfolioImages::where('user_id', $user_id)->where('portfolio_id', $portfolio_id)->orderBy('order')->get();
        $response = $this->successResponse(['images' => $imgs, 'base_url' => asset("storage/portfolio-images/$user_id/")], '!! Updated !!');
        return response()->json($response, 200);
    }

    /**
     * Uploading Files Only
     * @param Illuminate\Http\Request
     * @return Array
     */
    public function portfolioImages(Request $request)
    {
        $userId = auth()->user()->id;
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'image'
        ]);
        $data = [];
        if ($request->hasfile('images')) {
            if (count($request->file('images')) > 10) {
                return response()->json(['message' => "You can't upload more then 10 files. Please try again."], 422);
            }
            foreach ($request->file('images') as $file) {
                $name = "PORTFOLIO-IMAGE-" . date('Y-m-d') . '-' . rand(9999, 999999999) . '.' . $file->extension();
                $file->storeAs("public/portfolio-images/$userId/", $name);
                list($height, $width) = getimagesize($file);
                array_push($data, [
                    'name' => $name,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'height' => $height,
                    'width' => $width,
                ]);
            }
        }
        return response()->json($this->successResponse(['images' => $data, 'base_url' => asset("storage/portfolio-images/$userId/")], 'Files Uploaded Successfully.'), 200);
    }
}
