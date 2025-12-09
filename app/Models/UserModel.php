<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'fullname',
        'email',
        'mobile',
        'password',
        'profile_file'
    ];

    protected $useTimestamps = true;

    // Automatically hash password before insert/update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_BCRYPT
            );
        }
        return $data;
    }

    // Validation rules
    // protected $validationRules = [
    //     'fullname'     => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
    //     'email'        => 'required|valid_email|max_length[120]|is_unique[users.email,id,{id}]',
    //     'mobile'       => 'required|numeric|regex_match[/^[0-9]{10}$/]',
    //     'password'     => 'permit_empty|min_length[6]',
    //     'profile_file' => 'permit_empty'
    // ];

    // protected $validationMessages = [
    //     'email' => [
    //         'is_unique' => 'This email already exists in our database.',
    //     ],
    //     'mobile' => [
    //         'regex_match' => 'Mobile number must be exactly 10 digits.'
    //     ],
    // ];

    public function getAllUsers()
    {
        return $this->orderBy('id', 'DESC');
    }

    public function setUpdateValidationRules($id)
    {
        $this->validationRules['email'] = "required|valid_email|max_length[120]|is_unique[users.email,id,{$id}]";
    }

    
}
