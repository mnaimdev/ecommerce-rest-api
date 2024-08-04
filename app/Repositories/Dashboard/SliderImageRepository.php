<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SliderImageInterface;
use App\Enums\RedirectionalTypeEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\Category;
use App\Models\SliderImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SliderImageRepository implements SliderImageInterface
{
    public function sliderImage()
    {
        $sliderImage = SliderImage::all();
        return SendingResponse::response('success', 'Slider Image Info', $sliderImage, '', 200);
    }

    public function sliderImageStore($request)
    {
        // working with redirectional type
        if ($request->redirectional_type == RedirectionalTypeEnum::LTR->value) {
            $redirectionalType = RedirectionalTypeEnum::LTR->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::RTL->value) {
            $redirectionalType = RedirectionalTypeEnum::RTL->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::UTB->value) {
            $redirectionalType = RedirectionalTypeEnum::UTB->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::BTU->value) {
            $redirectionalType = RedirectionalTypeEnum::BTU->value;
        }

        $sliderImageId = SliderImage::insertGetId([
            'name'                      => $request->name,
            'redirectional_type'        => $redirectionalType,
            'status'                    => $request->status,
            'title'                     => $request->title,
            'title_font_size'           => $request->title_font_size,
            'title_color'               => $request->title_color,
            'sub_title'                 => $request->sub_title,
            'sub_title_color'           => $request->sub_title_color,
            'sub_title_font_size'       => $request->sub_title_font_size,
            'button_text'               => $request->button_text,
            'button_link'               => $request->button_link,
            'button_color'              => $request->button_color,
            'button_hover_color'        => $request->button_hover_color,
            'text_color'                => $request->text_color,
            'text_hover_color'          => $request->text_hover_color,
            'user_id'                   => $request->user()->id,
            'created_at'                => Carbon::now(),
        ]);

        if ($request->image != '') {
            $image = ImageHelper::saveImage($request->image, '/uploads/slider-image/');
            SliderImage::findOrFail($sliderImageId)->update(
                [
                    'image' => $image,
                ]
            );
        }

        $sliderImage = SliderImage::findOrFail($sliderImageId);

        return SendingResponse::response('success', 'Slider Image Created', $sliderImage, '', 200);
    }

    public function sliderImageUpdate($request, $id)
    {
        // working with redirectional type
        if ($request->redirectional_type == RedirectionalTypeEnum::LTR->value) {
            $redirectionalType = RedirectionalTypeEnum::LTR->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::RTL->value) {
            $redirectionalType = RedirectionalTypeEnum::RTL->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::UTB->value) {
            $redirectionalType = RedirectionalTypeEnum::UTB->value;
        } else if ($request->redirectional_type == RedirectionalTypeEnum::BTU->value) {
            $redirectionalType = RedirectionalTypeEnum::BTU->value;
        }

        $sliderImage = SliderImage::findOrFail($id);

        $sliderImage->update([
            'name'                      => $request->name,
            'redirectional_type'        => $redirectionalType,
            'status'                    => $request->status,
            'title'                     => $request->title,
            'title_font_size'           => $request->title_font_size,
            'title_color'               => $request->title_color,
            'sub_title'                 => $request->sub_title,
            'sub_title_color'           => $request->sub_title_color,
            'sub_title_font_size'       => $request->sub_title_font_size,
            'button_text'               => $request->button_text,
            'button_link'               => $request->button_link,
            'button_color'              => $request->button_color,
            'button_hover_color'        => $request->button_hover_color,
            'text_color'                => $request->text_color,
            'text_hover_color'          => $request->text_hover_color,
            'user_id'                   => $request->user()->id,
        ]);

        if ($request->image != '') {
            if ($sliderImage->image != '') {
                ImageHelper::removeImage($sliderImage->image);
            }
            $image = ImageHelper::saveImage($request->image, '/uploads/slider-image/');

            $sliderImage->update([
                'image' => $image,
            ]);
        }

        return SendingResponse::response('success', 'Slier Image Updated', $sliderImage, '', 200);
    }

    public function sliderImageDelete($id)
    {
        $sliderImage = SliderImage::findOrFail($id);

        if ($sliderImage->image != '') {
            ImageHelper::removeImage($sliderImage->image);
        }

        $sliderImage->delete();

        return SendingResponse::response('success', 'Slider Image Deleted', '', '', 200);
    }

    public function sliderImageShow($id)
    {
        $sliderImage = SliderImage::findOrFail($id);
        return SendingResponse::response('success', 'Slider Image', $sliderImage, '', 200);
    }
}
