public function getHeader(): ?View
{
$data = Actions\CreateAction::make();
return view('filament.orders.upload-file', compact('data'));

// Você pode definir aqui o que acontece quando o modal deve ser aberto
// Por exemplo, definir alguma variável de estado ou preparar dados
}

public $file = '';
public $building_name = '';

public function save()
{
if ($this->file != '') {
$import = new OrdersImport($this->building_name);
Excel::import($import, $this->file);
}

/*
Order::create(
[
'building_id' => 1,
'teamleader_id' => 1,
'service_id' => 1,
'description' => 'Import from excel',
'name' => 'Planilha convertida para csv',
'unit' => '123',
'paint-date' => '2024-04-04 13:30:00',
'cleaning-date' => '2024-04-04 12:30:00',
'status' => 'Created',
'building' => 'Park Lane - Se vier da planilha',
'building_address' => 'Address do Parklane - se vier do evento'
],
[
'building_id' => 1,
'teamleader_id' => 1,
'service_id' => 1,
'description' => 'Import from excel - 2regs',
'name' => 'Planilha convertida para csv - 2regs',
'unit' => '1233',
'paint-date' => '2024-02-02 10:30:00',
'cleaning-date' => '2024-02-03 11:30:00',
'status' => 'Created',
'building' => 'Park Lane - Se vier da planilha',
'building_address' => 'Address do Parklane - se vier do evento'
]

);*/
