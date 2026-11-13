<?php

namespace App\Services;

class CloudinaryImageStorage
{
    private const REFERENCE_PREFIX = 'cloudinary:';
    private string $cloudName;

    public function __construct()
    {
        $this->cloudName = env('CLOUDINARY_CLOUD_NAME', 'eswchevz');
    }

    public function url(?string $reference): ?string
    {
        if ($reference === null || $reference === '' || $reference === '—') {
            return null;
        }

        if (str_starts_with($reference, self::REFERENCE_PREFIX)) {
            $parts = explode(':', substr($reference, strlen(self::REFERENCE_PREFIX)), 2);
            if (count($parts) === 2) {
                [$version, $publicId] = $parts;
                return "https://res.cloudinary.com/{$this->cloudName}/image/upload/v{$version}/{$publicId}";
            }
        }

        if (str_starts_with($reference, 'https://') || str_starts_with($reference, 'http://')) {
            return $reference;
        }

        return "https://res.cloudinary.com/{$this->cloudName}/image/upload/{$reference}";
    }
}
