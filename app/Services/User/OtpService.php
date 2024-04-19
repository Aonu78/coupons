<?php

namespace App\Services\User;

use App\Models\User;
use App\Enum\Users\OtpType;
use Illuminate\Support\Str;
use App\Models\OtpVerifications;
use Twilio\Rest\Client;
use App\Notifications\ResetPasswordNotification;

final class OtpService
{
    public function __construct(
        private readonly OtpVerifications $verificationModels
    ) {}

    public function create(User $user, OtpType $otpType): OtpVerifications
    {
        $otpModel = $this->verificationModels->newInstance();

        $otpModel->otp_uuid = Str::uuid();
        $otpModel->otp_code = rand(100000, 999999);
        $otpModel->user_id = $user->id;

        $otpModel->save();

        if ($otpType === OtpType::PHONE) {
            $this->sendSms($user->phone_number, $otpModel->otp_code);
        } else {
            $user->notify(new ResetPasswordNotification($otpModel->otp_code));
        }

        return $otpModel;
    }

    public function findByCode(string $code): ?OtpVerifications
    {
        $query = $this->verificationModels->newQuery();

        return $query->where("otp_code", $code)->where("is_verified", false)->first();
    }

    private function sendSms(string $to, string $code): void
    {
        $sid = env("TWILIO_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $twilio->messages->create($to, [
            'from' => env("TWILIO_NUMBER"),
            'body' => "Your verification code is: {$code}",
        ]);
    }
}
