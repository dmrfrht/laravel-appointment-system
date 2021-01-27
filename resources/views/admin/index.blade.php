@extends('layouts.app')
@section('content')

  <div>
    <h4 class="text-center">Günü Gelen Randevular</h4>
    <admin-today-appointment-component></admin-today-appointment-component>


    <h4 class="text-center">Gelecek Randevular</h4>
    <admin-appointment-component></admin-appointment-component>

    <h4 class="text-center">Geçmiş Randevular</h4>
    <admin-last-appointment-component></admin-last-appointment-component>
  </div>

@endsection