    <!--
        Procedimento:
        recebe a variavel contendo todos os eventos e mostra no video.
        No futuro: le o evento, verifica os dados pintor, apt, descricao e data,
        grava no banco
        marca que sincronizou
        fecha
    -->
    <?php
        var_dump($crews);
    ?>
    <section class="content-header">
        <h1>
            Banco de eventos do GoogleCalendar
            <small>Calendar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fas tachometer-alt"></i>Home</a></li>
            <li><a href="#">Data Tables</a></li>
            <li class="active">Events</li>
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
                                                style="width: 20%;">Name
                                                </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                                                style="width: 20%;">Phone Mobile
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="width: 20%;">Email
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="width: 5%;">Receive Email Nofitication
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="width: 5%;">Receive SMS Notification
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="width: 5%;">Receive APP Notification
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($events as $event)
                                                <tr>
                                                    <td>{{ $event->location}}</td>
                                                    <td>{{ $event->startDate }}</td>
                                                    <td>{{ $event->startDateTime }}</td>
                                                    <td>{{ $event->endDate }}</td>
                                                    <td>{{ $event->endDateTime }}</td>
                                                    <td>{{ $event->description}}</td>
                                                    <td>{{ $event->name}}</td>
                                                    <?php
                                                        $crew = '';
                                                        $unit = '';
                                                        $obs = '';
                                                        $string_all = $event->name;
                                                        $needle = " ";
                                                        $pos = strpos($string_all, $needle);
                                                        if ( $pos == 0 ) {
                                                            $crew = $string_all;
                                                        } else {
                                                            $crew = substr($string_all, 0, $pos);
                                                            if ($crew == null ) {
                                                                $crew = $string_all;
                                                            } else {
                                                                $string_midle = substr($string_all, $pos+1, strlen($string_all));
                                                                $pos = strpos($string_midle, $needle);
                                                                if ($pos == 0 ) {
                                                                    $unit = $string_midle;
                                                                    $obs = "";
                                                                } else {
                                                                    $unit = substr($string_midle, 0, $pos);
                                                                    $obs = substr($string_midle, $pos+1, strlen($string_midle));
                                                                };
                                                            };
                                                        };
                                                    ?>
                                                    <td>Crew: {{$crew}} - Unit: {{$unit}} - Obs: {{$obs}} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

