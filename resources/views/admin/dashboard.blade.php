@extends('layouts.app')

@section('title')
Admin Dashboard
@endsection

@section('content')
 <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $todaApplicantsCount }}</h3>
                <p>TODA Applicants</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add" onclick="window.location.href='{{route('TODAapplication.create')}}'"></i>
              </div>
              <a href="{{ route('TODAapplication.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $podaApplicantsCount }}</h3>
                <p>PODA Applicants</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add" onclick="window.location.href='{{route('PODAapplication.create')}}'"></i>
              </div>
              <a href="{{ route('PODAapplication.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $ppfApplicantsCount }}</h3>
                <p>PUJ/PUB/FX applicants</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add" onclick="window.location.href='{{route('PPFapplication.create')}}'"></i>
              </div>
              <a href="{{ route('PPFapplication.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $serviceApplicantsCount }}</h3>
                <p>Service applicants</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add" onclick="window.location.href='{{route('ServiceApplication.create')}}'"></i>
              </div>
              <a href="{{ route('ServiceApplication.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $todaDroppingsCount }}</h3>
                <p>DROPPING (TODA)</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add" onclick="window.location.href='{{route('TODADropping.create')}}'"></i>
              </div>
              <a href="{{ route('TODADropping.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $podaDroppingsCount }}</h3>
                <p>DROPPING (PODA)</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add" onclick="window.location.href='{{route('PODAdropping.create')}}'"></i>
              </div>
              <a href="{{ route('PODAdropping.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        
        <div class="row">
          <section class="col-lg-7 connectedSortable"></section>
          <section class="col-lg-5 connectedSortable"></section>
        </div>
      </div>
    </section>
  </div>
@endsection