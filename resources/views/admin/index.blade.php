@extends('layouts.app')
@section('content')

  <div class="container">
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="waiting-tab" data-toggle="tab" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Onay Bekleyen Randevular</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Günü Gelen Randevular</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Gelecek Randevular</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Geçmiş Randevular</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">İptal Edilen Randevular</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
        <admin-waiting-appointment-component></admin-waiting-appointment-component>
      </div>
      <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
        <admin-today-appointment-component></admin-today-appointment-component>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <admin-appointment-component></admin-appointment-component>
      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <admin-last-appointment-component></admin-last-appointment-component>
      </div>
      <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
        <admin-cancel-appointment-component></admin-cancel-appointment-component>
      </div>
    </div>

  </div>
@endsection