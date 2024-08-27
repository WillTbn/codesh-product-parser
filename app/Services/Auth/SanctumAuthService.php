<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\ParamerInvalidException;
use App\Exceptions\PatternMessageException;
use App\Models\User;
use App\Repository\Eloquent\UserRepositoryEloquent;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Create new Auth Token
 */
class SanctumAuthService extends Service
{
    /**
     *  Email
     *
     * @var string
     */
    private string $email;

    /**
     * Password
     *
     * @var string
     */
    private string $password;

     /**
     * data
     *
     * @var array
     */
    public array $data;

    /**
     * token
     *
     * @var string
     */
    public string $token;

    /**
     * User object
     *
     * @var ?User
     */
    public ?User $user;

    /**
     * Service constructor
     *
     * @param string $email
     * @param string  $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function setData()
    {
        $this->data = [
            "name" => $this->user->name,
            "email" => $this->user->email,
            "email_verified_at" => $this->user->email_verified_at,
            "token" => $this->getToken(),
        ];
    }
    public function setUser()
    {
        $userRepository = new UserRepositoryEloquent();
        $this->user = $userRepository->getByEmail($this->email);
    }
    public function setToken()
    {
        $this->token =  $this->user->createToken($this->user->id)->plainTextToken;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getToken()
    {
        return $this->token;
    }


    /**
     * Execute service logic
     *
     * @return SanctumAuthService
     *
     * @throws InvalidCredentialsException
     * @throws InvalidParametersException
     */
    public function execute(): SanctumAuthService
    {

        $this->setUser();
        if (is_null($this->getUser())) {
            throw new PatternMessageException(message:'Email e/ou senha invalidos.');
        }
        if(!Hash::check($this->password, $this->user->password)){
            throw new PatternMessageException(message:'Email e/ou senha invalidos.');
        }

        PersonalAccessToken::where('tokenable_id', $this->user->id)->delete();
        $this->setToken();

        $this->setData();

        return $this;
    }
}
