<?php

	return [
'use_package_routes' => true,
// set this to false to customize route for file manager

'middlewares'        => ['web', 'auth'],
// determine middlewares that apply to all file manager routes

'allow_multi_user'   => true,
// true : user can upload files to shared folder and their own folder
// false : all files are put together in shared folder

'user_field'         => 'id',
// determine which column of users table will be used as user's folder name

'shared_folder_name' => 'shares',
// the name of shared folder

'thumb_folder_name'  => 'thumbs',
// the name of thumb folder

'images_dir'         => 'public/images/',
'images_url'         => '/public/images/',
// path and url of images

'files_dir'          => 'public/files/',
'files_url'          => '/public/files/',
// path and url of files
// valid image mimetypes
'valid_image_mimetypes' => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif'
    ],


// valid file mimetypes (only when '/laravel-filemanager?type=Files')
'valid_file_mimetypes' => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'application/pdf',
        'text/plain'
    ],
];