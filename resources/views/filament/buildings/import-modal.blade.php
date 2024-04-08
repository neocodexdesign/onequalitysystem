<div>
    <form wire:submit.prevent="importExcel">
        <input type="file" wire:model="excelFile" id="excelFile">
        <button type="submit">Upload</button>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const importButton = document.querySelector('[data-action="openImportExcelModal"]');
        if (importButton) { // Certifique-se de que o botão existe
            importButton.addEventListener('click', function() {
                Livewire.emit('openModal', 'import-excel'); // Use o nome correto do seu modal Livewire aqui
            });
        }
    });
    </script>
