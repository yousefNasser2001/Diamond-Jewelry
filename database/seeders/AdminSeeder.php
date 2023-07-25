<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = $this->createUser(
            name: 'ActHub Admin',
            user_type: User::ADMIN,
            email: 'admin@acthub.com',
            phone: '0567086704',
            password: bcrypt('admin@acthub.com'),
            email_verified_at: now(),
            remember_token: Str::random(10),
            address: 'Palestine-Gaza',
            avatar: 'assets/img/avatar.jpeg',
            plan_id: get_setting('admin_plan'),
        );

        Setting::updateOrCreate(['name' => ADMIN_ID], ['value' => $adminUser->id]);


        $adminUser->assignRole(User::SUPER_ADMIN_ROLE);

        $user = $this->createUser(
            name: 'User1',
            user_type: User::User,
            email: 'user1@acthub.com',
            phone: '0567086704',
            password: bcrypt('user1@acthub.com'),
            email_verified_at: now(),
            remember_token: Str::random(10),
            address: 'Palestine-Gaza',
            avatar: 'assets/img/avatar.jpeg',
            plan_id: get_setting('user_plan'),
        );


        $user->assignRole(User::USER_ROLE);

        $this->createUser(
            name: 'Company',
            user_type: User::User,
            email: 'company@acthub.com',
            phone: '0567086704',
            password: bcrypt('company@acthub.com'),
            email_verified_at: now(),
            remember_token: Str::random(10),
            address: 'Palestine-Gaza',
            avatar: 'assets/img/avatar.jpeg',
            plan_id: get_setting('company_plan'),
        );
    }


    public function createUser(
        $name,
        $user_type,
        $email,
        $phone,
        $password,
        $email_verified_at,
        $remember_token,
        $address,
        $avatar,
        $plan_id,

    ) {
        $user = new User();
        $user->name = $name;
        $user->user_type = $user_type;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = $password;
        $user->email_verified_at = $email_verified_at;
        $user->remember_token = $remember_token;
        $user->address = $address;
        $user->plan_id = $plan_id;
        $user->save();
        $avatar = $user->addAssetImage($avatar, User::USER_IMAGE_TAG);
        $user->avatar = $avatar->id;
        $user->save();
        return $user;
    }
}
