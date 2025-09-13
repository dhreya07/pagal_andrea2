<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['users'] = $this->UsersModel->all(); // fixed
        $this->call->view('users/index', $data);
    }

    public function create()
    {
        if ($this->io->method() == 'post') {
            $data = [
                'first_name' => $this->io->post('first_name'),
                'last_name'  => $this->io->post('last_name'),
                'email'      => $this->io->post('email')
            ];

            if ($this->UsersModel->insert($data)) {
                redirect(site_url(''));
            } else {
                echo "Error in creating user.";
            }
        } else {
            $this->call->view('users/create');
        }
    }

    public function update($id)
    {
        $user = $this->UsersModel->find($id);
        if (!$user) {
            echo "User not found.";
            return;
        }

        if ($this->io->method() == 'post') {
            $data = [
                'first_name' => $this->io->post('first_name'),
                'last_name'  => $this->io->post('last_name'),
                'email'      => $this->io->post('email')
            ];

            if ($this->UsersModel->update($id, $data)) {
                redirect();
            } else {
                echo "Error in updating user.";
            }
        } else {
            $this->call->view('users/update', ['user' => $user]);
        }
    }

    public function delete($id)
    {
        if ($this->UsersModel->delete($id)) {
            redirect();
        } else {
            echo "Error in deleting user.";
        }
    }
}
