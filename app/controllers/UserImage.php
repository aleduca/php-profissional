<?php

namespace app\controllers;
class UserImage
{
    public function store()
    {
        try {
            $path = upload(640, 480, 'assets/img', 'crop');

            $auth = user();

            read('photos');
            where('userId', $auth->id);

            $photoUser = execute(isFetchAll:false);

            if ($photoUser) {
                $updated = update('photos', [
                    'path' => $path
                ], [
                    'userId' => $auth->id
                ]);
                @unlink($photoUser->path);
            } else {
                $updated = create('photos', [
                    'userId' => $auth->id,
                    'path' => $path
                ]);
            }

            if ($updated) {
                $auth->path = $path;
                setMessageAndRedirect('upload_success', 'Upload feito com sucesso', '/user/edit/profile');
                return;
            }
            setMessageAndRedirect('upload_error', 'Ocorreu um erro ao fazer o upload', '/user/edit/profile');
        } catch (\Exception $e) {
            setMessageAndRedirect('upload_error', $e->getMessage(), '/user/edit/profile');
        }
    }
}
