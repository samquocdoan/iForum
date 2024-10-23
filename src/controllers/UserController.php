<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Controller;
use App\Core\Response;
use App\Manage\InputManager;
use App\Manage\SessionManager;
use App\Services\MyPhpMailer;
use App\Services\Validator;
use App\Services\UserService;

use PDO;
use PHPMailer\PHPMailer\PHPMailer;

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

    public function profile()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render('user/profile');
                break;
        }
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
                SessionManager::set('name', $this->user->name);
                SessionManager::set('role', $this->user->role);
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
            case 'PUT':
                MyPhpMailer::sendRegisterConfirm('samquocdoan.bank@gmail.com', 'Sam Quoc Doan');
                break;
            case 'POST':
                $this->user->name = trim(InputManager::inputJson('name'));
                $this->user->email = trim(InputManager::inputJson('email'));
                $this->user->password = trim(InputManager::inputJson('password'));
                $passwordConfirm = trim(InputManager::inputJson('passwordConfirm'));

                if (empty($this->user->name) || empty($this->user->email) || empty($this->user->password) || empty($passwordConfirm)) {
                    Response::error(message: "Các thông tin đăng nhập là bắt buộc.", code: 400);
                    return;
                }

                if ($this->user->password != $passwordConfirm) {
                    Response::error(message: "Mật khẩu không trùng khớp.", code: 401);
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
            case "GET":
                echo "Hello World";
                break;
            default:
                Response::error(message: "Method is not allowed.", code: 405);
                break;
        }
    }

    public function update()
    {
        $this->user->uid = 22; // Demo
        $fields = ['name', 'birthday', 'gender', 'address', 'email', 'status', 'role', 'avatar_path'];

        foreach ($fields as $field) {
            $this->user->$field = InputManager::inputJson($field);
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

        $result = $this->user->update();
        if ($result) {
            Response::success(message: "Cập nhật thông tin thành công.", code: 200);
        } else {
            Response::error(message: "Có lỗi xảy ra. Chưa thể cập nhật thông tin bây giờ.", code: 500);
        }
    }

    public function updatePassword()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render('user/updatePassword');
                break;
            case 'POST':
                $this->user->uid = 28;
                $oldPassword = InputManager::inputJson('oldPassword');
                $newPassword = InputManager::inputJson('newPassword');
                $newPasswordConfirm = InputManager::inputJson('newPasswordConfirm');

                if (empty($oldPassword) || empty($newPassword) || empty($newPasswordConfirm)) {
                    Response::error(message: "Tất cả các trường mật khẩu đều bắt buộc.", code: 400);
                    return;
                }

                $stmt = $this->user->getById();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$user) {
                    Response::error(message: "Người dùng này không tồn tại.", code: 401);
                    return;
                }

                if (intval($user['uid']) !== intval($this->user->uid)) {
                    Response::error(message: "Có gì đó không đúng. Bạn chưa thể đổi mật khẩu bây giờ.", code: 401);
                    return;
                }

                if ($newPassword !== $newPasswordConfirm) {
                    Response::error(message: "Mật khẩu mới không trùng khớp.", code: 401);
                    return;
                }

                if (!password_verify($oldPassword, $user['password'])) {
                    Response::error(message: "Mật khẩu cũ không chính xác.", code: 401);
                    return;
                }

                $isValidPassword = Validator::password($newPassword);
                if (!$isValidPassword['success']) {
                    Response::error(message: $isValidPassword['message'], code: 400);
                    return;
                }

                $this->user->password = password_hash($newPassword, PASSWORD_DEFAULT);
                $passwordStmt = $this->user->updatePassword();
                if ($passwordStmt) {
                    Response::success(message: "Mật khẩu đã được đổi thành công.", code: 200);
                } else {
                    Response::error(message: "Đổi mật khẩu thất bại. Thử lại sau.", code: 500);
                }
                break;
            default:
                Response::error(message: "Method is not allowed", code: 405);
                break;
        }
    }
}
