<?php

namespace App\Http\Enums;

final class StorageFileEnum
{
    const UPLOAD_MAX_FILE_SIZE = 200;

    const MIME_PNG = 'png';
    const MIME_JPEG = 'jpeg';
    const MIME_JPG = 'jpg';
    const MIME_PJPEG = 'pjpeg';
    const MIME_WEBP = 'webp';

    const IMAGE_MIMES = [
        self::MIME_PNG,
        self::MIME_JPEG,
        self::MIME_JPG,
        self::MIME_PJPEG,
        self::MIME_WEBP
    ];
}
