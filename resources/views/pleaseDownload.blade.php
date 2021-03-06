@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body text-center text-primary">
                  Please download the BRUMULTIVERSE App on Google Play or App Store to start your journey with us!
                    <div class="row justify-content-center text-center mt-2">
                        <div class="col-md-6 mb-2">
                          <a href="#">
                            <img src="{{ asset('img/welcome/googleplay.png') }}" class="img-fluid">
                          </a>
                        </div>
                        <div class="col-md-6 mb-2">
                          <a href="#">
                            <img src="{{ asset('img/welcome/appstore.png') }}" alt="" class="img-fluid">
                          </a>
                        </div>
                      </div>
                      <a href="/">Go back to Home Page.</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
