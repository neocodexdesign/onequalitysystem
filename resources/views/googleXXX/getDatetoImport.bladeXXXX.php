{{-- Exemplo de formulário na Blade --}}
<form action="{{ route('google.importfromgoogle') }}" method="POST">
    @csrf
    <label for="start">Início:</label>
    <input type="date" name="start" id="start" required>
    
    <label for="end">Fim:</label>
    <input type="date" name="end" id="end" required>
    
    <label for="status">Status:</label>
    <input type="text" name="status" id="status" required>
    
    <button type="submit">Import From Google Calendar</button>
</form>