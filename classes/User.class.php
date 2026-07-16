<?php
class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $secret_name;
    private $full_name;
    private $status;
    private $ip_address;
    private $user_agent;
    private $last_login;
    private $created_at;
    private $updated_at;

    public function __construct($data = []) {
        if(!empty($data)) {
            $this->hydrate($data);
        }
    }

    private function hydrate($data) {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            // print_r($method);
            // echo "<br>";
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getSecretName() {
        return $this->secret_name;
    }

    public function getFullName() {
        return $this->full_name;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function getIpAddress() {
        return $this->ip_address;
    }
    
    public function getUserAgent() {
        return $this->user_agent;
    }

    public function getLastLogin() {
        return $this->last_login;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }


    // public function get_Data($key, $default = false) {
    //     if(isset($_SESSION[$key])) {
    //         return $_SESSION[$key];
    //     } else {
    //         return $default;
    //     }
    // }

    // //Setters

    // public function set_Data($key, $value) {
    //     $_SESSION[$key] = $value;
    // }
    public function setId($id) {
        $this->id = (int)$id;
    }
    public function setUsername($username) {
        $this->username = trim($username);
    }
    public function setEmail($email) {
        $this->email = trim($email);
    }
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function setSecretName($secret_name = null) {
        if($secret_name === null) {
            $this->secret_name = bin2hex(random_bytes(16));
        } else {
            $this->secret_name = $secret_name;
        }
    }
    public function setFullName($full_name) {
        $this->full_name = trim($full_name);
    }
    public function setStatus($status) {
        $this->status = in_array($status, ['active', 'blocked']) ? $status : 'active';
    }
    public function setIpAddress($ip) {
        $this->ip_address = $ip;
    }
    public function setUserAgent($agent) {
        $this->user_agent = $agent;
    }
    public function setLastLogin($last_login) {
        $this->last_login = $last_login;
    }
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'secret_name' => $this->secret_name,
            'full_name' => $this->full_name,
            'status' => $this->status,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'last_login' => $this->last_login,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

