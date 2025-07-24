<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        helper(['form']);
        $this->userModel = new UserModel();
        $this->session = session();
    }

    // ===============================
    // LOGIN
    // ===============================
    public function login()
    {
        log_message('debug', 'TRAP: Entered login() method');
        helper(['form']);
        
        // Debug the request method
        $method = $this->request->getMethod();
        log_message('debug', 'TRAP: Request method is: ' . $method);
        
        // Write to trap file for debugging
        file_put_contents(FCPATH . 'trap_login.txt', $method . " request\n");
        
        // Debug POST data if any
        if (!empty($this->request->getPost())) {
            log_message('debug', 'TRAP: POST data: ' . json_encode($this->request->getPost()));
        } else {
            log_message('debug', 'TRAP: No POST data received');
        }

        if (strtolower($method) === 'post') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[5]',
            ];

            log_message('debug', 'Login POST data: ' . json_encode($this->request->getPost()));

            if (! $this->validate($rules)) {
                log_message('error', 'Login validation failed: ' . json_encode($this->validator->getErrors()));
                return view('auth/login', [
                    'validation' => $this->validator
                ]);
            }

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = $this->userModel->where('email', $email)->first();
            log_message('debug', 'Login user lookup: ' . json_encode($user));

            if ($user && password_verify($password, $user['password'])) {
                // Set user data in session
                $userData = [
                    'id'        => $user['id'],
                    'name'      => $user['name'],
                    'role'      => $user['role'],
                    'email'     => $user['email'],
                    'tenant_id' => $user['tenant_id'] ?? 1
                ];
                // Set both individual session keys and the 'user' key for AuthGuard
                $this->session->set([
                    'user_id'    => $user['id'],
                    'name'       => $user['name'],
                    'role'       => $user['role'],
                    'tenant_id'  => $user['tenant_id'] ?? 1,
                    'isLoggedIn' => true,
                    'user'       => $userData  // This is what AuthGuard checks for
                ]);
                
                log_message('debug', 'Login success for user: ' . $user['email']);
                return redirect()->to('/dashboard');
            } else {
                log_message('error', 'Login failed for email: ' . $email);
                return redirect()->back()->with('error', 'Invalid email or password');
            }
        }

        return view('auth/login');
    }

    // ===============================
    // REGISTER
    // ===============================

    public function register()
    {
        log_message('debug', 'TRAP: Entered register() method');
        helper(['form']);
        
        // Debug the request method
        $method = $this->request->getMethod();
        log_message('debug', 'TRAP: Request method is: ' . $method);
        
        // Write to trap file for debugging
        file_put_contents(FCPATH . 'trap_register.txt', $method . " request\n");
        
        // Debug POST data if any
        if (!empty($this->request->getPost())) {
            log_message('debug', 'TRAP: POST data: ' . json_encode($this->request->getPost()));
        } else {
            log_message('debug', 'TRAP: No POST data received');
        }

        if (strtolower($method) === 'post') {
            log_message('debug', 'TRAP: POST request detected');
            $rules = [
                'name'     => 'required|min_length[3]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'phone'    => 'required|is_unique[users.phone]',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                log_message('error', 'TRAP: Registration validation failed: ' . json_encode($this->validator->getErrors()));
                return view('auth/register', [
                    'validation' => $this->validator,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $userModel = new \App\Models\UserModel();
            $data = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'phone'    => $this->request->getPost('phone'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'user',
                'trial_ends_at' => date('Y-m-d', strtotime('+30 days')),
            ];
            log_message('debug', 'TRAP: Registration data: ' . json_encode($data));

            try {
                if (!$userModel->save($data)) {
                    // If save fails, get errors from model
                    $errors = $userModel->errors();
                    log_message('error', 'TRAP: Registration DB save failed: ' . json_encode($errors));
                    if (empty($errors)) {
                        $errors = ['Registration failed due to a database error.'];
                    }
                    return view('auth/register', [
                        'errors' => $errors
                    ]);
                }
                
                log_message('debug', 'TRAP: Registration successful for email: ' . $data['email']);
                return redirect()->to('/login')->with('success', 'Registered successfully. Please login.');
            } catch (\Exception $e) {
                log_message('error', 'TRAP: Exception during registration: ' . $e->getMessage());
                return view('auth/register', [
                    'errors' => ['An unexpected error occurred: ' . $e->getMessage()]
                ]);
            }
        }

        log_message('debug', 'TRAP: register() method loaded registration view');
        return view('auth/register');
    }


    // ===============================
    // LOGOUT
    // ===============================
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
