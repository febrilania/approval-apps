@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-3 p-lg-4">
        <p class="fs-5 fw-bold">PROFILE</p>
        <img src="{{ asset('storage/items/'.Auth::user()->profile_picture) }}" style="max-width: 20%">

        <table class="my-3">
            <tr style="">
                <td style="width: 100px; padding-block: 5px">Nama</td>
                <td style="width: 10px">:</td>
                <td>{{Auth::user()->name}}</td>
            </tr>
            <tr>
                <td style="width: 100px; padding-block: 5px">Username</td>
                <td style="width: 10px">:</td>
                <td>{{Auth::user()->username}}</td>
            </tr>
            <tr>
                <td style="width: 100px; padding-block: 5px">Role</td>
                <td style="width: 10px">:</td>
                <td>{{Auth::user()->role->role_name}}</td>
            </tr>
        </table>
        <a href="{{route('editProfileAdmin')}}" class="btn btn-primary ">Edit Profile</a>
    </div>
</div>