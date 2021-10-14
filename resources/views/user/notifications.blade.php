@extends('layouts.sidebar')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="{{ asset('/css/user.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/notifs.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="{{ asset('js/notifs.js') }}" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="col-md-9">
        <div class="row justify-content-center">
            <!--
                <div class="col-md-5 my-auto text-right">
                <a href="{{ route('notifications.desactivate') }}" type="button" class="btn-form delete_button">Désactiver toutes les notifications</a>
            </div>
            -->
            <div class="col-md-7 my-auto text-right">
                <button type="button" class="btn-form delete_button" data-toggle="modal" data-target="#modalSuppression">Supprimer toutes les notifications</button>
            </div>
                <div class="modal fade" id="modalSuppression" tabindex="-1" role="dialog" aria-labelledby="modalSuppression" aria-hidden="true" style="text-align: center;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" id="confirmation">
                            <div class="modal-body">
                                <h2>Êtes-vous sûr ?</h2>
                                Vous êtes sur le point de supprimer toutes vos notifications.
                                <br><br>
                                <a href="{{ route('notifications.deleteAll') }}" type="button" class="btn-perso-blue" alt="Submit" style="padding-top: 0.3vw; text-decoration: none; color: white">Confirmer</a>
                                <br><br><button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <br/><br/>
            @foreach ($notifications as $rawNotification)
                @php
                    //Récupération de l'user expediteur et du trip de la notification, si ils sont introuvable, on n'affiche pas la notification 
                    $user = App\Models\User::find($rawNotification->data['id_user_origin']);
                    $trip = App\Models\Trip::find($rawNotification->data['id_trip']);
                @endphp
                @if($user != NULL && $trip != NULL)
                    <div class="label-notif" id = "row_{{$rawNotification->id}}">
                        <div class="row" >
                            <div class="col" >
                                @php
                                    $user = App\Models\User::find($rawNotification->data['id_user_origin']);
                                @endphp
                                <img src="{{ isset($user->profile_pic) ? asset('storage/'.$user->username.'/'.$user->profile_pic) : asset('/images/avatar_notif.png') }}" class="avatar_notif" alt="avatar">
                            </div>
                            <div class="col-7">
                            @switch($rawNotification->type)
                                @case( Config::get('db.notificationType.trip_canceled') )
                                    @include('user/notifications/tripCanceled',['notifications'=>$rawNotification])
                                @break

                                @case( Config::get('db.notificationType.trip_request') )
                                    @include('user/notifications/tripRequest')
                                @break

                                @case( Config::get('db.notificationType.trip_request_canceled') )
                                    @include('user/notifications/tripRequestCanceled')
                                @break

                                @case( Config::get('db.notificationType.trip_request_accepted') )
                                    @include('user/notifications/tripRequestAccepted')
                                @break

                                @case( Config::get('db.notificationType.trip_request_refused') )
                                    @include('user/notifications/tripRequestRefused')
                                @break

                                @case( Config::get('db.notificationType.new_private_trip') )
                                    @include('user/notifications/newPrivateTrip',['notifications'=>$rawNotification])
                                @break

                                @default
                                    <p>You should not see that</p>
                                @endswitch

                            </div>
                            <div class="col">
                                    <span class="">
                                        @php
                                            echo date_format($rawNotification->created_at,"Y/m/d");
                                        @endphp
                                    </span>
                                    <span class="">
                                        @php
                                            echo date_format($rawNotification->created_at,"H:i");
                                        @endphp
                                    </span>
                            </div>
                            @switch($rawNotification->type)
                                @case( Config::get('db.notificationType.trip_request') )

                                    <!--accepter-->
                                    <div class="frame">
                                            <input type="image" src="{{ asset('images/check.png') }}" class="input-notif"  data-toggle="modal" data-target="#modalValidation" border="0" alt="Submit"/>
                                            <div class="modal fade" id="modalValidation" tabindex="-1" role="dialog" aria-labelledby="modalValidation" aria-hidden="true" style="text-align: center;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" id="confirmation">
                                                    <div class="modal-body">
                                                        <h2>Êtes-vous sûr ?</h2>
                                                        @php
                                                            $user = App\Models\User::find($rawNotification->data['id_user_origin']);
                                                        @endphp
                                                        Souhaitez-vous vraiment accepter la participation de {{ $user->username }} à votre trajet ?
                                                        <br><br>
                                                        <form action = "{{ route('trip.acceptRequest', [$rawNotification->data['id_user_origin'], $rawNotification->data['id_trip']],) }}">
                                                            <input type="hidden" value = "{{$rawNotification->id}}">
                                                            <button type="submit" class="btn-perso-blue">Confirmer</button>
                                                        </form>
                                                        <button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    </div>

                                    <!--refus-->
                                    <div class="frame">
                                        <input type="image" src="{{ asset('images/cross.png') }}" class="input-notif" border="0" alt="Submit" data-toggle="modal" data-target="#modalRefus"/>
                                        <div class="modal fade" id="modalRefus" tabindex="-1" role="dialog" aria-labelledby="modalRefus" aria-hidden="true" style="text-align: center;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" id="confirmation">
                                                    <div class="modal-body">
                                                        <h2>Êtes-vous sûr ?</h2>
                                                        @php
                                                            $user = App\Models\User::find($rawNotification->data['id_user_origin']);
                                                        @endphp
                                                        Souhaitez-vous vraiment refuser la participation de {{ $user->username }} à votre trajet ?
                                                        <br><br>
                                                        <form action = "{{ route('trip.refuseRequest', [$rawNotification->data['id_user_origin'], $rawNotification->data['id_trip']],) }}">
                                                            <input type="hidden" value = "{{$rawNotification->id}}">
                                                            <button type="submit" class="btn-perso-blue">Confirmer</button>
                                                        </form>
                                                        <button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @break
                            @endswitch

                            <div class="frame" style="margin-right: 1vw !important;">
                                <input type="image" src="{{ asset('images/poubelle.png') }}" class="input-notif" data-toggle="modal" data-target="#modalDelete" border="0" alt="Submit"/>
                                <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true" style="text-align: center;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" id="confirmation">
                                            <div class="modal-body">
                                                <h2>Êtes-vous sûr ?</h2>
                                                Souhaitez-vous vraiment supprimer cette notification ?
                                                <br><br>
                                                <form action = "{{ route('notification.delete') }}">
                                                    <input type="hidden" name="id" value = "{{$rawNotification->id}}">
                                                    <button type="submit" class="btn-perso-blue">Confirmer</button>
                                                </form>
                                                <button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <!--                        <div class="frame" style="margin-right: 1.5vw;">
                                <input type="image" src="{{ asset('images/triple_dot.png') }}" class="input-notif" border="0" id="defiler_{{$rawNotification->id}}" onclick="defilerNotif(this);" value="{{$rawNotification->id}} " alt="Détails"/>
                            </div>-->

                            <!--
                            <div class="row special_row">
                                <div class="special_col" id="special_col_{{$rawNotification->id}}">
                                    <form action = "{{--{{ route('?????') }}--}}" id="form-read-js">
                                        <input type="hidden" value = "{{$rawNotification->id}}" >
                                        <input type="submit" src="{{ asset('images/check.png') }}" class="btn-form delete_button" value="Désactiver les notifications"/>
                                    </form>
                                </div>
                            </div>-->

        <!--                    code "notification lue"-->
        <!--                    <div class="col">
                                @if($rawNotification->read_at == NULL)
                                    <form action = "{{ route('notification.read') }}" id="form-read-js">
                                        <input type="hidden" id="read-id-js" value = "{{$rawNotification->id}}" >
                                        <button type="submit" class="btn-form" >Read</button>
                                    </form>
                                @endif
                            </div>-->
                        </div>

                </div>
            @endif
            @endforeach
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection
