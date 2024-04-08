@extends('index')
@section('content')
    <!-- Aqui iremos colocar os dados da produção do sistema.
        Nessa seção estamos fazendo o topo da tabela de gerencimento de managers
        aqui vamos mostrar os dados da tabela e permitir a inclusão, exclusão, alteração
        e ver os dados de forma mais apurada dos managers.
        managers são os owners do sistema.
        O sistema vem com um manager cadastrado e seu login é
        emiliodami@gmail.com e a senha 123mudar
    -->
    <section class="content-header">
        <h1>
            Managers
            <small>Tables</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fas tachometer-alt"></i>Home</a></li>
            <li><a href="#">Data Tables</a></li>
            <li class="active">Managers</li>
        </ol>
    </section>
    <section class="content">


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- .box-header -->
                    <div class="box-body">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                                                    style="width: 30%;">Name
                                                </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                                                    style="width: 20%;">Phone Mobile
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30%;">Email
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                    style="width: 5%;">User
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($managers as $manager)

                                            <tr>
                                                    <td>{{$manager->name_managers}}</td>
                                                    <td>{{$manager->phone_managers}}</td>
                                                    <td>{{$manager->email_managers}}</td>
                                                    <td>{{$manager->id_users}}</td>

                                                    <td>
                                                        <button
                                                            class="btn btn-info"
                                                            data-my_table = "managers"
                                                            data-my_name_managers = "{{$manager->name_managers}}"
                                                            data-my_phone_managers = "{{$manager->phone_managers}}"
                                                            data-my_email_managers = "{{$manager->email_managers}}"
                                                            data-my_id_users = "{{$manager->id_users}}"
                                                            data-my_id_managers = "{{$manager->id}}"
                                                            data-toggle="modal"
                                                            data-target="#edit">Edit
                                                        </button>
                                                        <button
                                                            class="btn btn-danger"
                                                            data-my_table = "managers"
                                                            data-my_name_managers = "{{$manager->name_managers}}"
                                                            data-my_id_managers = "{{$manager->id}}"
                                                            data-toggle="modal"
                                                            data-target="#delete">Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                        <!-- Button trigger modal -->
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#myModal">
                                Add New
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="box box-primary box-header with-border">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New manager</h4>
                                        </div>
                                        <form action="{{route('managers.store')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="modal-body">
                                                @include('managers.form_edit')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal APPEND NEW RECORD -->

                         <!-- modal UPDATE -->
                        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="box box-primary box-header with-border">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Edit manager</h4>
                                        </div>
                                        <form action="{{route('managers.update', 'test')}}" method="post">
                                            {{method_field('patch')}}
                                            {{csrf_field()}}
                                            <div class="modal-body">
                                                <input type="hidden" name="id_managers" id="id_managers">
                                                @include('managers.form_edit')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal UPDATE -->

                        <!-- modal DELETE -->
                        <div class="modal modal-danger" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="box box-primary box-header with-border">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
                                        </div>
                                        <form action="{{route('managers.destroy','$manager->id')}}" method="post">
                                            {{method_field('delete')}}
                                            {{csrf_field()}}
                                            <div class="modal-body">
                                                <input class="form-control"
                                                    name="id_managers"
                                                    readonly="readonly"
                                                    id="id_managers"
                                                    type="hidden">
                                                <label>Name</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="name_managers"
                                                    readonly="readonly"
                                                    id="name_managers">
                                            </div>
                                            <div class="modal-footer">
                                                Are you sure you want to delete the manager?
                                                <button type="button" class="btn btn-success" data-dismiss="modal"> No, Cancel</button>
                                                <button type="submit" class="btn btn-warning"> Yes, Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal DELETE -->
                    </div>
                    <!-- end .box BODY -->
                </div>
                <!-- end BOX -->
            </div>
            <!-- end xs=12 -->
        </div>
        <!-- end ROW -->
    </section>
@endsection
