<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\UserAuthInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserAuthRepository implements UserAuthInterface
{
    public function userRegisterProcess($request)
    {
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role_id'       => $request->role_id,
            'created_at'    => Carbon::now(),
        ]);

        $token = $user->createToken('mytoken')->plainTextToken;

        return SendingResponse::response('success', 'User Created Successfully', '', $token, 200);
    }

    public function userLoginProcess($request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken("API TOKEN")->plainTextToken;

        return SendingResponse::response('success', 'User Logged In Successfully', '', $token, 200);
    }

    public function userLogoutProcess($request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return SendingResponse::response('success', 'User Logout Successfully', '', '', 200);
    }

    public function userInfo($request)
    {
        $user = $request->user();

        return SendingResponse::response('success', 'User Info', $user, '', 200);
    }

    public function userProfileUpdate($request)
    {
        $admin = $request->user();

        if ($admin->password == '') {
            $admin->update([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'nid_number'            => $request->nid_number,
                'passport_number'       => $request->passport_number,
                'phone'                 => $request->phone,
            ]);
        } else {
            $admin->update([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'nid_number'            => $request->nid_number,
                'passport_number'       => $request->passport_number,
                'phone'                 => $request->phone,
                'password'              => Hash::make($request->password)
            ]);
        }

        if ($request->profile_picture != '') {
            if ($admin->profile_picture != '') {
                ImageHelper::removeImage($admin->profile_picture);
            }
            $image = ImageHelper::saveImage($request->profile_picture, '/uploads/admin/');
            $admin->update(
                [
                    'profile_picture' => $image,
                ]
            );
        }

        if ($request->nid_image != '') {
            if ($admin->nid_image != '') {
                ImageHelper::removeImage($admin->nid_image);
            }
            $nidImage = ImageHelper::saveImage($request->nid_image, '/uploads/admin/nid/');
            $admin->update(
                [
                    'nid_image' => $nidImage,
                ]
            );
        }

        if ($request->passport_image != '') {
            if ($admin->passport_image != '') {
                ImageHelper::removeImage($admin->passport_image);
            }
            $passportImage = ImageHelper::saveImage($request->passport_image, '/uploads/admin/passport/');
            $admin->update(
                [
                    'passport_image' => $passportImage,
                ]
            );
        }

        $user = User::findOrFail($admin->id);

        return SendingResponse::response('success', 'User Profile Updated', $user, '', 200);
    }
}
