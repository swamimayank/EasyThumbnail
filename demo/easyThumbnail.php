<?php

/*
 *
 * To talk about this you can contact at mayankkumarswami@gmail.com
 *
 * Copyright (c) 2015, Mayank Kumar Swami
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

/**
 * @param $original_file_path
 * @param $new_width
 * @param $new_height
 * @param string $save_path
 * @param string $log   // By default log is false but can be enabled by passing param to true
 * @return bool|string  // It return thumbnail path on success and false if thumbnail not crated and
 *                        generate log
 */
function easy_thumbnail($original_file_path, $new_width, $new_height, $save_path = "", $log = "FALSE")
{


     
    if (!file_exists($original_file_path)) {

        if ($log) logger("Error : Original file not found at " . $original_file_path);
        return FALSE;
        exit;

    }

    $imgInfo = getimagesize($original_file_path);

    if (!$imgInfo) {
        if ($log) logger("Error : getimagesize return false for " . $original_file_path);
        return FALSE;
        exit;
    }

    $imgExtension = "";
    switch ($imgInfo[2]) {
        case 1:
            $imgExtension = '.gif';
            break;

        case 2:
            $imgExtension = '.jpg';
            break;

        case 3:
            $imgExtension = '.png';
            break;
        case 3:
            $imgExtension = '.jpeg';
            break;
    }

    if ($save_path == "") $save_path = "thumbnail" . $imgExtension;

    // Get new dimensions
    list($width, $height) = getimagesize($original_file_path);

    //  image Reassemble
    $resample = imagecreatetruecolor($new_width, $new_height);

    if (!$resample) {

        if ($log) logger("Error : Unable to Create a new true color image   for " . $original_file_path);
        return FALSE;
        exit;
    }

    if ($imgExtension == ".jpg") {
        $image = imagecreatefromjpeg($original_file_path);

    } else if ($imgExtension == ".gif") {
        $image = imagecreatefromgif($original_file_path);

    } else if ($imgExtension == ".png") {
        $image = imagecreatefrompng($original_file_path);

    } else if ($imgExtension == ".jpeg") {
        $image = imagecreatefromjpeg($original_file_path);
    }

    if (!$image) {
        if ($log) logger("Error : Unable to Create a new   image   from " . $original_file_path);
        return FALSE;
        exit;
    }

    $copy_image = imagecopyresampled($resample, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    if (!$copy_image) {

        if ($log) logger("Error : Unable to copy  image   of  " . $original_file_path);
        return FALSE;
        exit;
    }

    $res = FALSE;
    if ($imgExtension == ".jpg") {
        $res = imagejpeg($resample, $save_path);

    } else if ($imgExtension == ".gif") {
        $res = imagegif($resample, $save_path);

    } else if ($imgExtension == ".png") {
        $res = imagepng($resample, $save_path);

    } else if ($imgExtension == ".jpeg") {
        $res = imagejpeg($resample, $save_path);
    }

    if (!$res) {

        if ($log) logger("Error : Unable to create thumbnail for   " . $original_file_path);
        return FALSE;
        exit;
    }

    return $save_path;
}

function logger($str = '')
{
    $file = 'log.txt';
     
    file_put_contents($file, $str . PHP_EOL, FILE_APPEND);
}
