<div>
    <form wire:submit.prevent="submit">
        <input type="date" wire:model="dateFrom" required>
        <input type="date" wire:model="dateTo" required>
        <select wire:model="status" required>
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</div>
<script>
    window.openImportModal = function() {
        console.log("Abrindo modal...");
        Livewire.emit('openModal', 'import-google-calendar-form');
    };
    document.addEventListener('DOMContentLoaded', function () {
        console.log("O script está carregando corretamente.");
        const importButton = document.getElementById('import-from-google');
        if (importButton) {
            importButton.addEventListener('click', (event) => {
                event.preventDefault(); // Evitar o redirecionamento
                console.log("Botão clicado.");
                openImportModal();
            });
        } else {
            console.log("Botão não encontrado.");
        }
    });
</script>
