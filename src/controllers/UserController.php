<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Response.php';

class UserController extends Controller
{
    private $db;
    private $user;

    public function __construct($db)
    {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function login($email, $password)
    {
        # Logic here
    }

    public function getUserInfo($uid)
    {
        # Logic here
    }

    public function getAllUsers()
    {
        $stmt = $this->user->getAll();
        $userDatas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($userDatas) > 0) {
            Response::json($userDatas, 200);
        } else {
            Response::json(['message' => "Khong co nguoi dung nao."], 404);
        }
    }

    public function create()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render('user/create'); # Chuyen sang mang hinh dang ki tai khoan
                break;
            case 'POST':
                $this->user->name = trim($_POST['name']);
                $this->user->email = trim($_POST['email']);
                $this->user->password = trim($_POST['password']);
                
                if (empty($this->user->name) || empty($this->user->email) || empty($this->user->password)) {
                    Response::json(['message' => 'Các trường không được để trống.'], 400);
                    return;
                }

                if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
                    Response::json(['message' => 'Email không hợp lệ.'], 400);
                    return;
                }

                $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
                if ($this->user->create()) {
                    Response::json(['message' => 'Tạo tài khoản thành công!'], 201);
                } else {
                    Response::json(['message' => 'Tạo tài khoản thất bại!'], 500);
                }

                break;
            default:
                Response::json(['message' => 'Method not allowed.'], 401);                
        }
    }
}
