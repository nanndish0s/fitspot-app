<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Trainers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Available Trainers</h1>
    <div class="row">
        @foreach ($trainers as $trainer)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $trainer->user->name }}</h5>
                    <p class="card-text">
                        <strong>Specialization:</strong> {{ $trainer->specialization }}<br>
                        <strong>Hourly Rate:</strong> ${{ $trainer->hourly_rate }}<br>
                        <strong>Bio:</strong> {{ $trainer->bio }}
                    </p>
                    <h6>Services:</h6>
                    <ul>
                        @foreach ($trainer->services as $service)
                        <li>{{ $service->service_name }} - ${{ $service->price }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/bookings/create?trainer_id=' . $trainer->id) }}" class="btn btn-primary">Book Trainer</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>
