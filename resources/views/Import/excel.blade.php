<h1>Upload File</h1>
{{--$data--}}
<div class="flex justify-between mt-1">
    <div class="font-bold text-3xl">Events</div>

</div>
<form wire:submit="save" class="w-full max-w-sm flex mt-2">
    <div class="mb-4">

        <input class="shadow appearance-none border rounded w-full py-2 px-3
            text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="building_name" wire:model='building_name'>

        <input class="shadow appearance-none border rounded w-full py-2 px-3
            text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="fileInput" type="file" wire:model='file'>

        <div class="flex items-center justify-between mt-3">
            <button
                class="bg-red-500 hover:bg-blue-700 text-gray font-bold
                py-2 px-4 rounded focus:outline-none focus:shadow-out line" type="submit">
                Import
            </button>
        </div>
    </div>
</form>
