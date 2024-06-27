<?php

namespace App\Services;

use App\Contracts\Interfaces\ProfileInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Enums\UploadDiskEnum;
use App\Helpers\UserHelper;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Traits\UploadTrait;

class ProfileService
{
    use UploadTrait;

    private ProfileInterface $profile;
    public function __construct(ProfileInterface $profile)
    {
        $this->profile = $profile;
    }
    public function update(ProfileRequest $request)
    {
        $data = $request->validated();
        $old_photo = auth()->user()->photo;
        if ($request->hasFile('photo')) {
            if ($old_photo) {
                $this->remove($old_photo);
                $old_photo = $this->upload(UploadDiskEnum::USER->value, $request->file('photo'));
            }
            $old_photo = $this->upload(UploadDiskEnum::USER->value, $request->file('photo'));

        }
        return [
            'name'=>$data['name'],
            'email'=>$data['email'],
            'photo'=>$old_photo,
        ];
    }
}
