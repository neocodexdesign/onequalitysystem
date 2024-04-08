<div id="eventModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{ $event->id }} <br/>
                {{ $event->building_id }} <br/>
                {{ $event->teamleader_id }} <br/>
                {{ $event->service_id }} <br/>
                {{ $event->description }} <br/>
                {{ $event->from }} <br/>
                {{ $event->notes }} <br/>
                {{ $event->unit }} <br/>
                {{ $event->name }} <br/>
                {{ $event->service_date }} <br/>
                {{ $event->startDate }} <br/>
                {{ $event->endDate }} <br/>
                {{ $event->status }} <br/>
                {{ $event->paint_date }} <br/>
                {{ $event->cleaning_date }} <br/>
                {{ $event->startDateTime }} <br/>
                {{ $event->endDateTime }} <br/>
                {{ $event->created_at }} <br/>
                {{ $event->updated_at }} <br/>
                {{ $event->building }} <br/>
                {{ $event->team }} <br/>
                {{ $event->building_address }} <br/>


            </div>
        </div>
    </div>
</div>
