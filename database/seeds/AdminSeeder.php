<?php

namespace Database\Seeders;

use App\Role;
use App\User;
use App\About;
use App\Character;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name'=>'Khiara',
            'last_name'=>'pasion',
            'type'=>'super admin',
            'email'=>'admin@admin.bru',
            'password'=>Hash::make('admin')
        ]);

        DB::table('scripts')->insert([
            'name'=>'copyright_disclaimer',
            'message'=>'I certify that I own sole copyright of all the materials I have uploaded on this site and my account, and that I have obtained permission in writing to use them, in case I share copyright with another individual or entity. I hold BRUMULTIVERSE free of liabilities should any copyright infringement occurs.'
        ]);

        DB::table('genres')->insert([
            ['name'=>'Teen & Young Adult'],
            ['name'=>'New Adult'],
            ['name'=>'Romance'],
            ['name'=>'Detective & Thrillers'],
            ['name'=>'Action'],
            ['name'=>'Historical'],
            ['name'=>'Horror'],
            ['name'=>'LGBTQIA+'],
            ['name'=>'Poetry'],
        ]);
        DB::table('settings')->insert([
            'event_day_away'=>'60'
        ]);
        // //test users
        // DB::table('users')->insert([
        //     'first_name'=>'William',
        //     'last_name'=>'Galas',
        //     'role'=>'author',
        //     'email'=>'william@mail.com',
        //     'email_verified_at'=>now(),
        //     'password'=>Hash::make('password') // password,
        // ]);

        // User::find(1)->interests()->create([
        //     'type'=>'college',
        //     'name'=>'Integrated School',
        //     'description'=>'Integrated School'
        // ]);
        Character::create([
            'name'=>'Khiara Laurea'
        ]);
        Character::create([
            'name'=>'ANTONINA'
        ]);
        Character::create([
            'name'=>'JULIO'
        ]);

        Role::create([
            'name'=>'dashboard',
            'desc'=>'View dashboard.'
        ]);
        Role::create([
            'name'=>'audio-book',
            'desc'=>'access to audio book management page.'
        ]);
        Role::create([
            'name'=>'art',
            'desc'=>'access to art management page.'
        ]);
        Role::create([
            'name'=>'aan',
            'desc'=>'access to aan management page.'
        ]);
        Role::create([
            'name'=>'book',
            'desc'=>'access to book management page.'
        ]);
        Role::create([
            'name'=>'trailer',
            'desc'=>'access to trailer management page.'
        ]);
        Role::create([
            'name'=>'event',
            'desc'=>'access to event management page.'
        ]);
        Role::create([
            'name'=>'bin',
            'desc'=>'access to bin management page.'
        ]);
        Role::create([
            'name'=>'genre',
            'desc'=>'access to genre management page.'
        ]);
        Role::create([
            'name'=>'character',
            'desc'=>'access to character management page.'
        ]);
        Role::create([
            'name'=>'message',
            'desc'=>'access to message page.'
        ]);

        Role::create([
            'name'=>'profile',
            'desc'=>'access to profile page.'
        ]);
        Role::create([
            'name'=>'admin',
            'desc'=>'access to administrator management page.'
        ]);
        Role::create([
            'name'=>'recommendation',
            'desc'=>'access to recommendation page.'
        ]);
        
        Role::create([
            'name'=>'group',
            'desc'=>'access to group approval page.'
        ]);

        Role::create([
            'name'=>'user',
            'desc'=>'access to user listing'
        ]);

        Role::create([
            'name'=>'ticket',
            'desc'=>'access to tickets'
        ]);

        About::create([
            'content'=>'<p>The brainchild of Khiara Laurea and Miel Salva, and co-created by Isagani Madlangbayan, BRUMULTIVERSE is vast, having multifold dimensions and realms, and parallel realities and universes, characters that come to life in the dead of night, and names that echo whispered dreams and stirred feelings. It is an immense plane, where billions of stories, waiting to be told, exist. Some of the best ones have already been written, while others await their rightful storytellers.</p><br/><p>Precisely because of that, BRUMULTIVERSE explores the infinite potentials and promises of human existence and circumstances we have yet to understand. It is ever expanding, built and rooted firmly in the joint musings, imaginations, beliefs, perceptions and conceptions of the Filipino creators and of authors and artists of all genres and from varying backgrounds around the globe.</p></br><p>In 2021, BRUMULTIVERSE is launched and introduced through Realidad Dimension, one of six dimensions, for its first phase. Within this dimension is Tellurian Realm or the realm of the living and of reality. And here, on Earth, is a university, where all its mysteries unfold.</p>'
        ]);

        
        
    }
}
