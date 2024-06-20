<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/' => 'Home',
        '/Tasks' => 'Tasks',
        '/Tasks/Import' => 'Import from Google',
    ]" />
    <h1>Import From Google</h1>
    <div class="flex justify-between mt-3">
        <div class="font-bold text-3xl">Events</div>
    </div>
    <div class="flex items-center space-x-2">    
        <form wire:submit.prevent="save" class="w-full flex items-center space-x-2">
            <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-6" type="date" wire:model="dateFrom" required>
            <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-6" type="date" wire:model="dateTo" required>
            <select class="shadow appearance-none border rounded py-2 px-13 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-6" wire:model="status" required>
                <option value="">Select Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="all">All</option>
            </select>
            <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Import From Google Calendar
            </button>
        </form>
        <!-- Botão adicional removido; já incluso na parte do formulário -->
        <button wire:click="consistbuildings" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Processar Buildings
        </button>
        <button wire:click="exportToOrders" class="bg-yellow-500 hover:bg-blue-700 text-white font-bold py-2 
                   px-4 rounded focus:outline-none focus:shadow-outline">
            Export to Orders
        </button>
    </div>

</div>
