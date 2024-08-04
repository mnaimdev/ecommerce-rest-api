<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\CategoryInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryInterface
{
    public function category()
    {
        $categories = Category::with('category')->get();
        return SendingResponse::response('success', 'Category Info', $categories, '', 200);
    }

    public function categoryStore($request)
    {
        $categoryId = Category::insertGetId([
            'parent_id'             => $request->parent_id,
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'serial_no'             => $request->serial_no,
            'description'           => $request->description,
            'meta_tag'              => $request->meta_tag,
            'meta_title'            => $request->meta_title,
            'meta_description'      => $request->meta_description,
            'status'                => $request->status,
            'is_featured'           => $request->is_featured,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        if ($request->image != '') {
            $image = ImageHelper::saveImage($request->image, '/uploads/category/');
            Category::findOrFail($categoryId)->update(
                [
                    'image' => $image,
                ]
            );
        }

        if ($request->banner_image != '') {
            $bannerImage = ImageHelper::saveImage($request->banner_image, '/uploads/category/');
            Category::findOrFail($categoryId)->update(
                [
                    'banner_image' => $bannerImage,
                ]
            );
        }

        $category = Category::findOrFail($categoryId);

        return SendingResponse::response('success', 'Category Created', $category, '', 200);
    }

    public function categoryUpdate($request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'user_id'               => $request->user()->id,
            'parent_id'             => $request->parent_id,
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'serial_no'             => $request->serial_no,
            'description'           => $request->description,
            'meta_tag'              => $request->meta_tag,
            'meta_title'            => $request->meta_title,
            'meta_description'      => $request->meta_description,
            'status'                => $request->status,
            'is_featured'           => $request->is_featured,
        ]);

        if ($request->image != '') {
            if ($category->image != '') {
                ImageHelper::removeImage($category->image);
            }
            $image = ImageHelper::saveImage($request->image, '/uploads/category/');

            $category->update([
                'image' => $image,
            ]);
        }

        if ($request->banner_image != '') {
            if ($category->banner_image != '') {
                ImageHelper::removeImage($category->banner_image);
            }
            $bannerImage = ImageHelper::saveImage($request->banner_image, '/uploads/category/');

            $category->update([
                'banner_image' => $bannerImage,
            ]);
        }

        return SendingResponse::response('success', 'Category Updated', $category, '', 200);
    }

    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image != '') {
            ImageHelper::removeImage($category->image);
        }

        if ($category->banner_image != '') {
            ImageHelper::removeImage($category->banner_image);
        }

        $category->delete();

        return SendingResponse::response('success', 'Category Deleted', '', '', 200);
    }

    public function categoryShow($id)
    {
        $category = Category::findOrFail($id);
        return SendingResponse::response('success', 'Category', $category, '', 200);
    }
}
