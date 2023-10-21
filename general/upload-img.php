<?php
function handle_img_upload(): bool | string
{
    if (!isset($_FILES['img'])) {
        return false;
    }

    $img = $_FILES['img'];

    if ($img['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $destination = __DIR__ . '/general/images/' . $filename;

    move_uploaded_file($img['tmp_name'], $destination);

    return $filename;
}

function remove_img_file(string $filename): bool
{
    $path = __DIR__ . '/general/images/' . $filename;
    if (!file_exists($path)) {
        return false;
    }
    return unlink($path);
}
