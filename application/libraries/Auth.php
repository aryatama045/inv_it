<?php
/**
 * Author: Firoz Ahmad Likhon <likh.deshi@gmail.com>
 * Website: https://github.com/firoz-ahmad-likhon
 *
 * Copyright (c) 2018 Firoz Ahmad Likhon
 * Released under the MIT license
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{
    /*
    |--------------------------------------------------------------------------
    | Auth Library
    |--------------------------------------------------------------------------
    |
    | This Library handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */
    protected $CI;

    public $user = null;
    public $userID = null;
    public $userName = null;
    public $password = null;
    public $roles = 0;  // [ public $roles = null ] codeIgniter where_in() omitted for null.
    public $permissions = null;
    public $loginStatus = false;
    public $error = array();

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->init();
    }

    /**
     * Initialization the Auth class
     */
    protected function init()
    {
        if ($this->CI->session->has_userdata("userID") && $this->CI->session->loginStatus) {
            $this->userID = $this->CI->session->userID;
            $this->userName = $this->CI->session->userName;
            $this->roles = $this->CI->session->roles;
            $this->loginStatus = true;
        }

        return;
    }

    /**
     * Show The Login Form
     *
     * @param array $data
     * @return mixed
     */
    public function showLoginForm($data = array())
    {
        return $this->CI->load->view("login", $data);
    }

    /**
     * Handle Login
     *
     * @param $request
     * @return array|bool|void
     */
    public function login($request)
    {

        if ($this->validate($request)) {
            $this->user = $this->credentials($this->userName, $this->password);

            // $this->tahunajar = $this->credentials_tahunajar($this->userName, $this->password);

            if ($this->user) {

                return $this->setUser();

            } else {
                return $this->failedLogin($request);
            }
        }

        return false;
    }

    /**
     * Validate the login form
     *
     * @param $request
     * @return bool
     */
    protected function validate($request)
    {

        $this->CI->form_validation->set_rules('username','User Login','required',
				array(	'required' 	=> 'User Login Tidak Boleh Kosong !!',
				));
		$this->CI->form_validation->set_rules('password','Password','required',
				array(	'required' 	=> 'Password Tidak Boleh Kosong !!',
				));

        if ($this->CI->form_validation->run() == TRUE) {
            /*$this->userName = $request["username"];
            $this->password = $request["password"];*/
            $this->userName = $this->CI->input->post("username", TRUE);
            $this->password = $this->CI->input->post("password", TRUE);
            return true;
        }

        return false;
    }

    /**
     * Check the credentials
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    protected function credentials($username, $password)
    {
        $user = $this->CI->db->get_where("users", array("username" => $username, "status" => 1, "deleted_at" => null))->row(0);
        if($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }


    protected function credentials_tahunajar()
    {
        $ta = $this->CI->db->get_where("mst_ta", array( "aktif" => 1))->row(0);
        return $ta;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function authenticate()
    {
        if (!$this->loginStatus()) {
            return redirect('login');
        }

        return true;
    }

    /**
     * Determine if the current user is authenticated. Identical of authenticate()
     *
     * @return bool
     */
    public function check($methods = 0)
    {

        if (is_array($methods) && count(is_array($methods))) {
            foreach ($methods as $method) {
                if ($method == (is_null($this->CI->uri->segment(2)) ? "index" : $this->CI->uri->segment(2))) {
                    return $this->authenticate();
                }
            }
        }
        return $this->authenticate();
    }

    /**
     * Determine if the current user is authenticated to view the route/url
     *
     * @return bool|void
     */
    public function route_access()
    {

        $this->check();

        $routeName = (!is_null($this->CI->uri->segment(2)) ?  $this->CI->uri->segment(1) . "-" . $this->CI->uri->segment(2) : $this->CI->uri->segment(1) );


        if ($this->CI->uri->segment(1) == 'dashboard'){
            return true;
        }

        // tesx($routeName);

        if ($this->CI->uri->segment(1) . "-" . $this->CI->uri->segment(2) == 'pmb-dashboard_pmb'){
            return true;
        }

        if($this->can($routeName)){
            return true;
        }

        $sess = $this->CI->session->userdata();

        $sess = $sess['pmb_proses'];

        if(!empty($sess)){
            return redirect('pmb/page404', 'refresh');
        } else {
            return redirect('dashboard/page404', 'refresh');
        }


    }



    /**
     * Setting session for authenticated user
     */
    protected function setUser()
    {
        $this->userID = $this->user->id;

        $this->CI->session->set_userdata(array(
            "userID"        => $this->user->id,
            "name"          => $this->user->name,
            "username"      => $this->user->username,
            "pmb_proses"    => $this->user->pmb,
            "roles"         => $this->userWiseRoles(),
            "semester_aktif"        => $this->tahunajar->smt,
            "tahunajaran_aktif"     => $this->tahunajar->ta,
            "loginStatus"   => true
        ));

        $t = $this->user->pmb;

        if ($this->user->pmb == 'aktif'){
            return redirect("pmb/dashboard_pmb");
        }else{
            return redirect("dashboard");
        }
    }


    /**
     * Get the error message for failed login
     *
     * @param $request
     * @return array
     */
    protected function failedLogin($request)
    {

        $this->data['error'] = 'Username or Password Incorrect.';

        $this->CI->session->set_flashdata('error', 'Username or Password Incorrect.');

        return $this->data;
    }

    /**
     * Check login status
     *
     * @return bool
     */
    public function loginStatus()
    {
        return $this->loginStatus;
    }


    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->loginStatus();
    }

    /**
     * Read authenticated user ID
     *
     * @return int
     */
    public function userID()
    {
        return $this->userID;
    }

    /**
     * Read authenticated user Name
     *
     * @return string
     */
    public function userName()
    {
        return $this->userName;
    }

    /**
     * Read authenticated user roles
     *
     * @return array
     */
    public function roles()
    {
        return $this->roles;
    }

    /**
     * Read authenticated user permissions
     *
     * @return array
     */
    public function permissions()
    {
        return $this->permissions;
    }

    /**
     * Read the current user roles ID
     *
     * @param $userID
     * @return string
     */
    protected function userWiseRoles()
    {
        return array_map(function ($item) {
            return $item["role_id"];
        }, $this->CI->db->get_where("roles_users", array("user_id" => $this->userID()))->result_array());
    }

    /**
     * Read the current user roles name
     *
     * @return array
     */
    public function userRoles()
    {
        return array_map(function ($item) {
            return $item["name"];
        }, $this->CI->db
            ->select("roles.*")
            ->from("roles")
            ->join("roles_users", "roles.id = roles_users.role_id", "inner")
            ->where(array("roles_users.user_id" => $this->userID(),"roles.status" => 1, "deleted_at" => null))
            ->get()->result_array());
    }

    /**
     * Read current user permissions name
     *
     * @return mixed
     */
    public function userPermissions()
    {
        return array_map(function ($item) {
            return $item["name"];
        }, $this->CI->db
        ->select("permissions.*")
        ->from("permissions")
        ->join("permission_roles", "permissions.id = permission_roles.permission_id", "inner")
        ->where_in("permission_roles.role_id", $this->roles())
        ->where(array("permissions.status" => 1, "deleted_at" => null))
        ->group_by("permission_roles.permission_id")
        ->get()->result_array());
    }

    /**
     * Determine if the current user is authenticated for specific methods.
     *
     * @param array $methods
     * @return bool
     */
    public function only($methods = array())
    {
        if (is_array($methods) && count(is_array($methods))) {
            foreach ($methods as $method) {
                if ($method == (is_null($this->CI->uri->segment(2)) ? "index" : $this->CI->uri->segment(2))) {
                    return $this->route_access();
                }
            }
        }

        return true;
    }

    /**
     * Determine if the current user is authenticated except specific methods.
     *
     * @param array $methods
     * @return bool
     */
    public function except($methods = array())
    {
        if (is_array($methods) && count(is_array($methods))) {
            foreach ($methods as $method) {
                if ($method == (is_null($this->CI->uri->segment(2)) ? "index" : $this->CI->uri->segment(2))) {
                    return true;
                }
            }
        }

        return $this->route_access();
    }

    /**
     * Checks if the current user has a role by its name.
     *
     * @param $roles
     * @param bool $requireAll
     * @return bool
     */
    public function hasRole($roles, $requireAll = false)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->checkRole($role) && !$requireAll)
                    return true;
                elseif (!$this->checkRole($role) && $requireAll) {
                    return false;
                }
            }
        } else {
            return $this->checkRole($roles);
        }
        // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
        // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
        // Return the value of $requireAll;
        return $requireAll;
    }

    /**
     * Check current user has specific role
     *
     * @param $role
     * @return bool
     */
    public function checkRole($role)
    {
        return in_array($role, $this->userRoles());
    }

    /**
     * Check if current user has a permission by its name.
     *
     * @param $permissions
     * @param bool $requireAll
     * @return bool
     */
    public function can($permissions, $requireAll = false)
    {

        if (is_array($permissions)) {

            foreach ($permissions as $permission) {
                if ($this->checkPermission($permission) && !$requireAll)
                    return true;
                elseif (!$this->checkPermission($permission) && $requireAll) {
                    return false;
                }
            }
        } else {
            return $this->checkPermission($permissions);

        }
        // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
        // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
        // Return the value of $requireAll;
        return $requireAll;
    }

    /**
     * Check current user has specific permission
     *
     * @param $permission
     * @return bool
     */
    public function checkPermission($permission)
    {
        return in_array($permission, $this->userPermissions());
    }

    /**
     * Logout
     *
     * @return bool
     */
    public function logout()
    {
        $this->CI->session->unset_userdata(array("userID", "username", "pmb_proses", "loginStatus"));
        $this->CI->session->sess_destroy();

        return true;
    }
}