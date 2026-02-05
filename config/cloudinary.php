<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),

    /**
    * Upload Preset Configuration
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /**
    * Notification URL Configuration
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
];