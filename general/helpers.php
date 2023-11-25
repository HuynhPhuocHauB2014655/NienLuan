<?php
function handle_phone_img_upload(): bool | string
{
    if (!isset($_FILES['phone_img'])) {
        return false;
    }

    $phone_img = $_FILES['phone_img'];

    if ($phone_img['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $extension = pathinfo($phone_img['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $destination = 'images/' . $filename;
    move_uploaded_file($phone_img['tmp_name'], $destination);

    return $filename;
}

function remove_avater_file(string $filename): bool
{
    $path = 'images/' . $filename;
    if (!file_exists($path)) {
        return false;
    }
    return unlink($path);
}
