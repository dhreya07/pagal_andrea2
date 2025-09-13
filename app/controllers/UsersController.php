class UserController extends Controller { 

    public function __construct() {
        parent::__construct();
        $this->call->model('UsersModel'); // load model once in constructor
    }

    public function index(): void {
        $data['users'] = $this->UsersModel->all(); 
        $this->call->view('users/index', $data);
    }

    public function create(): void {
        if($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');

            $data = array(
                'username' => $username,
                'email'    => $email
            );

            if($this->UsersModel->insert($data)) {
                redirect('/');
            } else {
                echo "Error saving user";
            }
        } else {
            $this->call->view('users/create');
        }
    }

    public function update($id): void {
        $user = $this->UsersModel->find($id);

        if(!$user) {
            echo "User not found";
            return;
        }

        if($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');

            $data = array(
                'username' => $username,
                'email'    => $email
            );

            if($this->UsersModel->update($id, $data)) {
                redirect('/');
            } else {
                echo "Error updating user";
            }
        } else {
            $data['user'] = $user;
            $this->call->view('users/update', $data);
        }
    }
}
