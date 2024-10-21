@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Detail Item</p>
        <p>{{$item->item_name}}</p>
        <p>{{$item->unit_price}}</p>
        <img width="300px" height="300px" src="{{asset('storage/items/'.$item->image)}}" alt="gambar">
    </div>
</div>