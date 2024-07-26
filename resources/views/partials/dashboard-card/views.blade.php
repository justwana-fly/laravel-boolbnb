<!-- resources/views/partials/dashboard-card/views.blade.php -->

<div class="card mb-3">
    <div id="views-title" class="p-3">Views</div>
    <div class="card-body">
        <canvas id="viewsChart" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('viewsChart').getContext('2d');
        // Codice per il grafico delle visualizzazioni (da implementare)
    });
</script>
@endpush
