<?php 

//
//       _/_/_/                      _/            _/_/_/_/_/
//    _/          _/_/      _/_/    _/  _/              _/      _/_/      _/_/
//   _/  _/_/  _/_/_/_/  _/_/_/_/  _/_/              _/      _/    _/  _/    _/
//  _/    _/  _/        _/        _/  _/          _/        _/    _/  _/    _/
//   _/_/_/    _/_/_/    _/_/_/  _/    _/      _/_/_/_/_/    _/_/      _/_/
//
//
//  Copyright (c) 2015-2016, Geek Zoo Studio
//  http://www.geek-zoo.com
//
//
//  Permission is hereby granted, free of charge, to any person obtaining a
//  copy of this software and associated documentation files (the "Software"),
//  to deal in the Software without restriction, including without limitation
//  the rights to use, copy, modify, merge, publish, distribute, sublicense,
//  and/or sell copies of the Software, and to permit persons to whom the
//  Software is furnished to do so, subject to the following conditions:
//
//  The above copyright notice and this permission notice shall be included in
//  all copies or substantial portions of the Software.
//
//  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
//  FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
//  IN THE SOFTWARE.
//

namespace Backend;

use \DB;
use \User;
use \View;
use \Input;
use \Certify;
use \Mycertify;
use \Redirect;
use \Request;
use \Response;
use \Validator;
use \AdminLog;
class MycertifyController extends BaseController {
    
    // 添加我的认证
    public function postAdd() {
        $user_id    = Input::get('user_id', '');
        $certify_id = Input::get('certify_id', '');
        $my_certify = DB::table('my_certify')->where('user_id', '=', $user_id)->where('certify_id', '=', $certify_id)->get();
        if(!empty($my_certify)){
            return Redirect::back()->withMessage('已添加过了')->withColor('danger');
        }
        $certify = new Mycertify;
        $certify->user_id           = Input::get('user_id', '');
        $certify->certify_id        = Input::get('certify_id', '');
        $certify->save();
        AdminLog::log($certify->id, "添加“".User::userinfo($certify->user_id)."”的认证");
        return Redirect::back()->withMessage('创建成功！');
    }

    // 删除我的认证
    public function getDel($id) {
        $certify = Mycertify::find($id);
        if ($certify) {
            DB::table('my_certify')->where('id', $id)->delete();
            AdminLog::log($id, "删除“".User::userinfo($certify->user_id)."”的认证");
        }    
        return Redirect::back()->withMessage('取消成功！');
    }

}