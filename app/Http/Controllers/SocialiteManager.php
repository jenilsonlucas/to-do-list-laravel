<?php

namespace App\Http\Controllers;

use App\SocialiteInterface;
use Illuminate\Http\Request;
use InvalidArgumentException;

class SocialiteManager extends Controller
{
    public function driver(string $provider): SocialiteInterface
    {
        return match($provider) {
            'google' => new GoogleSocialite,
            default => throw new InvalidArgumentException("provedor {$provider} não suportado")
        };

    }
}
