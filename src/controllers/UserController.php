<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Controller;
use App\Core\Response;
use App\Manage\InputManager;
use App\Manage\SessionManager;
use App\Services\Validator;
use App\Services\UserService;

use PDO;

class UserController extends Controller
{
    private $db;
    private $user;
    private $services;

    public function __construct($db)
    {
        $this->db = $db;
        $this->user = new User($db);
        $this->services = new UserService($db, $this->user);
    }

    public function login()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render('user/login');
                break;
            case 'POST':
                $email = trim(InputManager::inputJson('email'));
                $password = trim(InputManager::inputJson('password'));

                if (empty($email) || empty($password)) {
                    Response::error(message: 'Vui lòng không để trống thông tin đăng nhập.', code: 400);
                    return;
                }

                $this->user->email = $email;
                $this->user->password = $password;

                $stmt = $this->user->login();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    Response::error(message: 'Thông tin đăng nhập chưa chính xác.', code: 401, errors: ['field' => 'user', 'message' => 'User is not exists.']);
                    return;
                }

                if (!password_verify($this->user->password, $user['password'])) {
                    Response::error(message: 'Thông tin đăng nhập chưa chính xác.', code: 401, errors: ['field' => 'password', 'message' => 'Wrong password.']);
                    return;
                }

                $this->user->name = $user['name'];
                $this->user->uid = $user['uid'];


                // Save session
                SessionManager::start(); # one week
                SessionManager::set('uid', $this->user->uid);
                SessionManager::set('role', $this->user->role);
                $this->render('user/login');
                Response::success(message: 'Đăng nhập thành công.', code: 200, data: ['name' => $this->user->name]);
                break;
            default:
                Response::error('Method is not allowed', code: 405);
                break;
        }
    }

    public function create()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render('user/create');
                break;
            case 'POST':
                $this->user->name = trim(InputManager::inputJson('name'));
                $this->user->email = trim(InputManager::inputJson('email'));
                $this->user->password = trim(InputManager::inputJson('password'));

                if (empty($this->user->name) || empty($this->user->email) || empty($this->user->password)) {
                    Response::error(message: "Các thông tin đăng nhập là bắt buộc.", code: 400);
                    return;
                }

                $isValidUsername = Validator::name($this->user->name);
                if (!$isValidUsername['success']) {
                    Response::error(message: $isValidUsername['message'], code: 400);
                    return;
                }

                $isValidateEmail = Validator::email($this->user->email);
                if (!$isValidateEmail['success']) {
                    Response::error(message: $isValidateEmail['message'], code: 400);
                    return;
                }

                $isValidatePassword = Validator::password($this->user->password);
                if (!$isValidatePassword['success']) {
                    Response::error(message: $isValidatePassword['message'], code: 400);
                    return;
                }

                if ($this->services->emailExists()) {
                    Response::error(message: "Email đăng ký đã được sử dụng.", code: 409);
                    return;
                }

                $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
                if ($this->user->create()) {
                    Response::success(message: "Đăng ký tài khoản thành công.", code: 201);
                } else {
                    Response::error(message: "Đăng ký tài khoản thất bại. Thử lại sau.", code: 500);
                }
                break;
            default:
                Response::error(message: "Method not allowed.", code: 405);
                break;
        }
    }

    public function delete()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                $this->user->uid = SessionManager::get('uid');
                $this->user->email = InputManager::inputJson("email");
                $this->user->password = InputManager::inputJson("password");

                $userStmt = $this->user->getById();
                $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

                if ($userResult['uid'] !== $this->user->uid) {
                    Response::error(message: "Có gì đó không ổn! Bạn chưa thể xóa tài khoản bây giờ.", code: 400);
                    return;
                }

                if (!$userResult) {
                    Response::error(message: "Người dùng không tồn tại.", code: 404);
                    return;
                }

                if (!password_verify($this->user->password, $userResult['password'])) {
                    Response::error(message: "Mật khẩu xác nhận không chính xác.", code: 400);
                    return;
                }

                $deleteResult = $this->user->delete();
                if ($deleteResult) {
                    $this->render('user/login');
                } else {
                    Response::error(message: "Đã xảy ra lỗi. Bạn chưa thể xóa tài khoản bây giờ.", code: 500);
                }
                break;
            default:
                Response::error(message: "Method is not allowed.", code: 405);
                break;
        }
    }
}
