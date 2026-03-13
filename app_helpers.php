<?php

if (!function_exists('h')) {
    function h($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('ensure_upload_dir')) {
    function ensure_upload_dir(string $relativeDir = 'upload/valuation_images'): string
    {
        $base = __DIR__ . DIRECTORY_SEPARATOR . trim($relativeDir, '/\\');
        if (!is_dir($base)) {
            @mkdir($base, 0775, true);
        }
        return $base;
    }
}

if (!function_exists('normalize_images_json')) {
    function normalize_images_json($raw): array
    {
        if (is_array($raw)) {
            return $raw;
        }

        if (!$raw || !is_string($raw)) {
            return [];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        $parts = array_filter(array_map('trim', explode(',', $raw)));
        $items = [];
        foreach ($parts as $path) {
            $items[] = [
                'path' => $path,
                'name' => basename($path),
                'is_cover' => false,
                'sort' => 0,
            ];
        }

        return $items;
    }
}

if (!function_exists('images_json_encode')) {
    function images_json_encode(array $images): string
    {
        $clean = [];
        $sort = 0;

        foreach ($images as $img) {
            if (empty($img['path'])) {
                continue;
            }

            $clean[] = [
                'path' => str_replace('\\', '/', (string)$img['path']),
                'name' => isset($img['name']) ? (string)$img['name'] : basename((string)$img['path']),
                'is_cover' => !empty($img['is_cover']),
                'sort' => isset($img['sort']) ? (int)$img['sort'] : $sort,
                'rotation' => isset($img['rotation']) ? (int)$img['rotation'] : 0,
            ];
            $sort++;
        }

        return json_encode(array_values($clean), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('get_cover_image')) {
    function get_cover_image(array $images): ?array
    {
        foreach ($images as $img) {
            if (!empty($img['is_cover'])) {
                return $img;
            }
        }
        return $images[0] ?? null;
    }
}

if (!function_exists('allowed_image_extension')) {
    function allowed_image_extension(string $name): bool
    {
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'jfif', 'png', 'gif', 'webp'], true);
    }
}

if (!function_exists('safe_upload_filename')) {
    function safe_upload_filename(string $originalName): string
    {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $base = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($originalName, PATHINFO_FILENAME));
        $base = trim($base, '-');
        if ($base === '') {
            $base = 'img';
        }
        return $base . '-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    }
}

if (!function_exists('create_image_resource')) {
    function create_image_resource(string $path, string $ext)
    {
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
            case 'jfif':
                return @imagecreatefromjpeg($path);
            case 'png':
                return @imagecreatefrompng($path);
            case 'gif':
                return @imagecreatefromgif($path);
            case 'webp':
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false;
            default:
                return false;
        }
    }
}

if (!function_exists('save_image_resource')) {
    function save_image_resource($img, string $path, string $ext, int $quality = 82): bool
    {
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
            case 'jfif':
                return @imagejpeg($img, $path, max(55, min(88, $quality)));
            case 'png':
                imagesavealpha($img, true);
                return @imagepng($img, $path, 6);
            case 'gif':
                return @imagegif($img, $path);
            case 'webp':
                return function_exists('imagewebp') ? @imagewebp($img, $path, max(55, min(88, $quality))) : false;
            default:
                return false;
        }
    }
}

if (!function_exists('fix_exif_orientation')) {
    function fix_exif_orientation(string $path, string $ext): void
    {
        if (!function_exists('exif_read_data')) {
            return;
        }

        if (!in_array($ext, ['jpg', 'jpeg', 'jfif'], true)) {
            return;
        }

        $exif = @exif_read_data($path);
        if (empty($exif['Orientation'])) {
            return;
        }

        $img = @imagecreatefromjpeg($path);
        if (!$img) {
            return;
        }

        switch ((int)$exif['Orientation']) {
            case 3:
                $img = imagerotate($img, 180, 0);
                break;
            case 6:
                $img = imagerotate($img, -90, 0);
                break;
            case 8:
                $img = imagerotate($img, 90, 0);
                break;
            default:
                imagedestroy($img);
                return;
        }

        @imagejpeg($img, $path, 85);
        imagedestroy($img);
    }
}

if (!function_exists('compress_image_if_needed')) {
    function compress_image_if_needed(string $path, int $maxBytes = 1048576): void
    {
        if (!function_exists('imagecreatetruecolor')) {
            return;
        }

        clearstatcache(true, $path);
        if (!file_exists($path) || filesize($path) <= $maxBytes) {
            return;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $src = create_image_resource($path, $ext);
        if (!$src) {
            return;
        }

        $width = imagesx($src);
        $height = imagesy($src);

        if ($width <= 0 || $height <= 0) {
            imagedestroy($src);
            return;
        }

        $ratio = min(1600 / $width, 1600 / $height, 1);
        $newW = max(1, (int)round($width * $ratio));
        $newH = max(1, (int)round($height * $ratio));

        $dst = imagecreatetruecolor($newW, $newH);

        if (in_array($ext, ['png', 'webp'], true)) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $width, $height);

        $quality = 82;
        save_image_resource($dst, $path, $ext, $quality);

        clearstatcache(true, $path);
        while (file_exists($path) && filesize($path) > $maxBytes && $quality > 58 && in_array($ext, ['jpg', 'jpeg', 'jfif', 'webp'], true)) {
            $quality -= 6;
            save_image_resource($dst, $path, $ext, $quality);
            clearstatcache(true, $path);
        }

        imagedestroy($src);
        imagedestroy($dst);
    }
}

if (!function_exists('process_uploaded_images')) {
    function process_uploaded_images(array $files, string $field = 'valuation_images'): array
    {
        if (empty($files[$field]) || empty($files[$field]['name']) || !is_array($files[$field]['name'])) {
            return [];
        }

        $uploadDir = ensure_upload_dir();
        $saved = [];

        foreach ($files[$field]['name'] as $i => $name) {
            if (empty($name)) {
                continue;
            }

            $tmp = $files[$field]['tmp_name'][$i] ?? '';
            $err = $files[$field]['error'][$i] ?? UPLOAD_ERR_NO_FILE;

            if ($err !== UPLOAD_ERR_OK || !$tmp || !is_uploaded_file($tmp)) {
                continue;
            }

            if (!allowed_image_extension($name)) {
                continue;
            }

            $fileName = safe_upload_filename($name);
            $target = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

            if (!@move_uploaded_file($tmp, $target)) {
                continue;
            }

            $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            fix_exif_orientation($target, $ext);
            compress_image_if_needed($target);

            $saved[] = [
                'path' => 'upload/valuation_images/' . $fileName,
                'name' => $name,
                'is_cover' => false,
                'sort' => count($saved),
                'rotation' => 0,
            ];
        }

        return $saved;
    }
}

if (!function_exists('apply_cover_to_images')) {
    function apply_cover_to_images(array $images, $coverPath): array
    {
        $coverPath = trim((string)$coverPath);
        foreach ($images as &$img) {
            $img['is_cover'] = ($coverPath !== '' && isset($img['path']) && $img['path'] === $coverPath);
        }
        unset($img);

        if ($coverPath === '' && !empty($images)) {
            $images[0]['is_cover'] = true;
        }

        return $images;
    }
}

if (!function_exists('remove_deleted_images')) {
    function remove_deleted_images(array $images, array $deleteList): array
    {
        $deleteMap = array_fill_keys(array_map('strval', $deleteList), true);
        $result = [];

        foreach ($images as $img) {
            $path = (string)($img['path'] ?? '');
            if ($path !== '' && isset($deleteMap[$path])) {
                $full = __DIR__ . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
                if (is_file($full)) {
                    @unlink($full);
                }
                continue;
            }
            $result[] = $img;
        }

        return array_values($result);
    }
}