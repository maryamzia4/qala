<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Custom Commission Request</title>
</head>
<body>
    <h2>New Custom Commission Request</h2>

    <p><strong>Commission Title:</strong> {{ $commission->title }}</p>
    <p><strong>Customer Name:</strong> {{ $commission->name }}</p>
    <p><strong>Customer Email:</strong> {{ $commission->email }}</p>
    <p><strong>Canvas Size:</strong> {{ $commission->canvas_size }}</p>
    <p><strong>Description:</strong> {{ $commission->description }}</p>
    <p><strong>Deadline:</strong> {{ $commission->deadline }}</p>
    <p><strong>Budget:</strong> {{ $commission->budget }}</p>
    <p><strong>Delivery Type:</strong> {{ $commission->delivery_type }}</p>
    <p><strong>Reference Images:</strong></p>
    
    @if ($commission->reference_images)
        <ul>
            @foreach (json_decode($commission->reference_images) as $image)
                <li><a href="{{ asset('storage/' . $image) }}" target="_blank">View Image</a></li>
            @endforeach
        </ul>
    @else
        <p>No reference images provided.</p>
    @endif

    <p>Login to view and respond to the commission request.</p>
</body>
</html>
