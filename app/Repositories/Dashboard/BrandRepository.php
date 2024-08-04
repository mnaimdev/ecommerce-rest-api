<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\BrandInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BrandRepository implements BrandInterface
{
    public function brand()
    {
        $brands = Brand::all();
        return SendingResponse::response('success', 'Brand Info', $brands, '', 200);
    }

    public function brandStore($request)
    {
        $brandId = Brand::insertGetId([
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'serial_no'             => $request->serial_no,
            'description'           => $request->description,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        // if ($request->hasFile('image')) {
        if ($request->image != '') {
            $image = ImageHelper::saveImage($request->image, '/uploads/brand/');
            Brand::findOrFail($brandId)->update(
                [
                    'image' => $image,
                ]
            );
        }

        // if ($request->hasFile('banner_image')) {
        if ($request->banner_image != '') {
            $bannerImage = ImageHelper::saveImage($request->banner_image, '/uploads/brand/');
            Brand::findOrFail($brandId)->update(
                [
                    'banner_image' => $bannerImage,
                ]
            );
        }

        $brand = Brand::findOrFail($brandId);

        return SendingResponse::response('success', 'Brand Created', $brand, '', 200);
    }

    public function brandUpdate($request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->update([
            'user_id'               => $request->user()->id,
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'serial_no'             => $request->serial_no,
            'description'           => $request->description,
            'status'                => $request->status,
        ]);

        if ($request->image != '') {
            if ($brand->image != '') {
                ImageHelper::removeImage($brand->image);
            }

            $image = ImageHelper::saveImage($request->image, '/uploads/brand/');

            $brand->update([
                'image' => $image,
            ]);
        }

        if ($request->banner_image != '') {
            if ($brand->banner_image != '') {
                ImageHelper::removeImage($brand->banner_image);
            }

            $bannerImage = ImageHelper::saveImage($request->banner_image, '/uploads/brand/');

            $brand->update([
                'banner_image' => $bannerImage,
            ]);
        }

        return SendingResponse::response('success', 'Brand Updated', $brand, '', 200);
    }

    public function brandDelete($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image != '') {
            ImageHelper::removeImage($brand->image);
        }

        if ($brand->banner_image != '') {
            ImageHelper::removeImage($brand->banner_image);
        }

        $brand->delete();

        return SendingResponse::response('success', 'Brand Deleted', '', '', 200);
    }

    public function brandShow($id)
    {
        $brand = Brand::findOrFail($id);

        return SendingResponse::response('success', 'Brand', $brand, '', 200);
    }
}
