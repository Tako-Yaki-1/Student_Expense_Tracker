<?php
class AuthController {
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login(string $username, string $password): bool {
        $record = $this->user->findByUsername($username);
        if ($record && password_verify($password, $record['password'])) {
            $_SESSION['user_id'] = $record['id'];
            $_SESSION['name'] = $record['name'];
            $_SESSION['role'] = $record['role'];
            return true;
        }
        return false;
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }
}
?>