<?php

namespace App;

interface SocialiteInterface
{
    public function redirectToProvider();
    public function handleProviderCallback();
}
