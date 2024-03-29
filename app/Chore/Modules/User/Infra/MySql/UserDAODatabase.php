<?php

namespace App\Chore\Modules\User\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\User\Entities\Location;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\UserMapper;
use Exception;

class UserDAODatabase extends UserMapper implements UserRepository
{

    private DBConnection $connection;

    public IDateTime $time;
    public function __construct(DBConnection $connection, IDateTime $time)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;
    }

    public function register(User $user, IDateTime $date): bool
    {

        $query = "INSERT INTO users (id, name, email, password, remember_token, created_at, updated_at)
                  VALUES (:id, :name, :email, :password, :remember_token, :created_at, :updated_at)";

        $params = [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "password" =>$user->password,
            "remember_token" => $user->rememberToken,
            "created_at" => $date->format('Y-m-d H:i:s'),
            "updated_at" => $date->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;

    }

    /**
     * @throws Exception
     */
    public function findUserByEmail(string $email)
    {
        $query = "select * from users u where u.email = :email";
        $params = ['email' => $email];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }
    public function findUserById(string $id): ?User
    {
        $query = "select u.*, GROUP_CONCAT(distinct(uf.comedian_id))  as followingComedians from users u
         left join user_follows uf on u.id = uf.user_id
         where u.id = :id GROUP BY u.id";
        $params = ['id' => $id];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }

    public function followComedian(User $user, Comedian $comedian, string $id)
    {
        $query = "INSERT INTO user_follows (id, comedian_id, user_id, created_at, updated_at)
                  VALUES (:id, :comedian_id, :user_id, :created_at, :updated_at)";

        $params = [
            "id" => $id,
            "user_id" => $user->id,
            "comedian_id" => $comedian->id,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;
    }
    public function unFollowComedian(User $user, Comedian $comedian)
    {
        $query = "DELETE FROM user_follows WHERE comedian_id = :user_id and comedian_id = :comedian_id ";

        $params = [
            "user_id" => $user->id,
            "comedian_id" => $comedian->id,
        ];

        $this->connection->query($query, $params);
        return true;
    }

    public function checkIfIsFollowAComedian(User $user, Comedian $comedian)
    {
        $query = "select c.* from user_follows uf
            inner join comedians c on uf.comedian_id = c.id
         where uf.user_id = :user_id and uf.comedian_id = :comedian_id";
        $params = ['user_id' => $user->id, 'comedian_id' => $comedian->id];

        $userData = $this->connection->query($query, $params);

        return count($userData);
    }

    public function listFollowComedians(User $user)
    {
        $query = "select u.*, GROUP_CONCAT(distinct(uf.comedian_id)) as followingComedians from users u
         left join user_follows uf on u.id = uf.user_id
         where u.id = :id GROUP BY u.id";
        $params = ['id' => $user->id];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }

    public function registerLocation(Location $location, User $user)
    {
        $query = "INSERT INTO user_locations (id, user_id, street, neighbourhood, city, state, country, zipcode, formattedAddress, lat, lng, created_at, updated_at)
                  VALUES (:id, :user_id, :street, :neighbourhood, :city, :state, :country, :zipcode, :formattedAddress, :lat, :lng, :created_at, :updated_at)";

        $params = [
            "id" => $location->id,
            "user_id" => $location->userId,
            "street" => $location->street,
            "neighbourhood" => $location->neighbourhood,
            "city" => $location->city,
            "state" => $location->state,
            "country" => $location->country,
            "zipcode" => $location->zipcode,
            "formattedAddress" => $location->formattedAddress,
            "lat" => $location->lat,
            "lng" => $location->lng,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;
    }
}
