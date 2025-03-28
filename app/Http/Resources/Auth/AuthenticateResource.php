<?php

namespace App\Http\Resources\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class AuthenticateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "username" => $this->username,
            "name" => $this->name,
            "access_token" => $this->access_token,
            "refresh_token" => $this->refresh_token,
            "created_at" => Carbon::parse($this->created_at)->toDateTimeString(),
            "updated_at" => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
