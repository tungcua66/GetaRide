@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@section('content')
    <div class="panel-body container" align="center">
        <header class="header">
            <h3 align="center">Mes groupes crées</h3>
        </header>
        <div class="table-responsive container" align="center" id="table_created_group_div">
            <table class="table table-striped table-bordered" id="table_created_group">
                <thead>
                <tr>
                    <th>Nom</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $group)
                    <tr>
                        <td>
                            <label style="color: #d6d8db" for={{$group->name}}>{{$group->name}}</label>
                        </td>
                        <td class="last_cell" style="width:30%;border:0px">
                            <button type="button" class="btn-perso-small open" data-toggle="modal" name="open" id="open"
                                    data-id-group="{{$group->id}}"
                                    data-user="{{$participant}}"
                                    data-name="{{$group->name}}"
                                    data-target="#detailsModal">+ de détails</button><br>
                            <div class=" modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div id="contenuModal" class="modal-content">
                                        <!--TODO : Front End améliorer l'interface du renommer le nom selon CDC -->
                                        <div id="body-modal" class="modal-body" align="center">
                                            <label for="id_group">Groupe n°</label>
                                            <input  type="text" readonly="readonly" id="id_group" name="id_group"><br>
                                            <label >Renommer le groupe </label>
                                            <form id="form_change_group_name"  method="GET" enctype="multipart/form-data">
                                                Nouveau nom:<input type="text" name="name"><br>
                                            <!-- Input pour changer le nom du groupe-->
                                            <!-- Récupérer ici les membres du groupes et les afficher dans une table-->
                                            <button type="submit" name="change" class="btn-perso change" >Sauvegarder</button>
                                            </form>
                                                <div >
                                                    <table class="table" id="item_table">
                                                    </table>
                                                </div>
                                            <button type="button" class="btn-perso" data-dismiss="modal">Retour</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button"  class="btn-perso-small open-suppr" data-toggle="modal"
                                    data-group-name="{{$group->name}}"
                                    data-id="{{$group->id}}"
                                    data-target="#modalSuppression">Supprimer</button>
                            <div class="modal fade" id="modalSuppression" tabindex="-1" role="dialog" aria-labelledby="modalSuppression" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" id="confirmation">
                                        <div class="modal-body">
                                            <h2>Êtes-vous sûr ?</h2>
                                            Vous êtes sur le point de supprimer le groupe <span id="group_name_suppr" style="font-weight:bold"></span>.<br>Une fois confirmé, le système supprimera le groupe et ce dernier ne pourra plus être récupéré.
                                            <br><br><a id="link_suppr_group"><button type="button" name="suppr_group" class="btn-perso-blue">Confirmer</button></a>
                                            <br><br><button type="button"  class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal_suppr_utilisateur" tabindex="-1" role="dialog" aria-labelledby="modal_suppr_utilisateur" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" id="conf">
                                        <div  class="modal-body ">
                                            <h2>Êtes-vous sûr ?</h2>
                                            Vous êtes sur le point de supprimer cette utilisateur <span id="suppr_user" style="font-weight:bold"></span>.<br>Une fois confirmé, le système supprimera le groupe et ce dernier ne pourra plus être récupéré.
                                            <br><br><a id="link_suppr_user" ><button type="button" class="btn-perso-blue">Confirmer</button></a>
                                            <br><br><button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="container" align="center">
            <a href="../dashboard"><button class="btn-perso" type="button">Revenir à l'accueil</button></a>
        </div>

    </div>
    <script type="text/javascript" src="{{asset('js/groups.js')}}"></script>

@endsection

