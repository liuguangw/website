<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/16
 * Time: 12:20
 */

namespace App\Http\Controllers;


use App\models\UploadFile;
use App\models\User;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        if (empty($user)) {
            $user = new User();
            $user->fill(['username' => 'user' . time(), 'password' => Hash::make('123456'), 'nickname' => 'test', 'email' => 'admin@qq . com']);
            $user->save();
        } else {
            if ($user->avatarFile !== null) {
                $user->avatarFile->delete();
            }
            $avatarFile = new UploadFile();
            $avatarFile->fill(['path' => time() . ' . png', 'file_size' => 10, 'extension' => 'png', 'ref_count' => 1]);
            $avatarFile->save();
            $user->avatarFile()->associate($avatarFile);
        }
        return $user->load('avatarFile');
    }
}
