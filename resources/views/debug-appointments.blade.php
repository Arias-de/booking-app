<!DOCTYPE html>
<html>
<head>
    <title>Debug - Tous les RDV</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>🔍 Debug - Tous les rendez-vous</h1>

    @php
        $appointments = App\Models\Appointment::orderBy('created_at', 'desc')->get();
    @endphp

    <p><strong>Total : {{ $appointments->count() }} rendez-vous</strong></p>

    @if($appointments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th>Créé le</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $apt)
                    <tr>
                        <td>{{ $apt->id }}</td>
                        <td>{{ $apt->client_name }}</td>
                        <td>{{ $apt->service->name ?? 'N/A' }}</td>
                        <td>{{ $apt->appointment_date }}</td>
                        <td>{{ $apt->appointment_time }}</td>
                        <td>{{ $apt->status }}</td>
                        <td>{{ $apt->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: red;">Aucun rendez-vous en base de données !</p>
    @endif

    <br>
    <a href="{{ route('dashboard') }}">← Retour au dashboard</a>
</body>
</html>
