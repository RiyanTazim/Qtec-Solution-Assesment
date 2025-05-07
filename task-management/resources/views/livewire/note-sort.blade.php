<div>
    <ul id="sortable" class="list-group">
        @foreach ($notes as $note)
            <li class="list-group-item" data-id="{{ $note['id'] }}">
                {{ $note['title'] }} — 
                @if($note['priority'] == 1)
                    High
                @elseif($note['priority'] == 2)
                    Low
                @else
                    Medium
                @endif
            </li>
        @endforeach
    </ul>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        let el = document.getElementById('sortable');
        Sortable.create(el, {
            animation: 150,
            onEnd: function () {
                let orderedIds = Array.from(el.children).map(item => item.dataset.id);
                Livewire.emit('updateTaskOrder', orderedIds);
            }
        });
    });
</script>
@endpush
