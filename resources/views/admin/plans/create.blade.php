<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Creation Form</title>
    <style>
        /* Form Styling */
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Grid View Styling */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .plan-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .plan-item strong {
            display: block;
            font-size: 20px;
            margin-bottom: 10px;
            color: #007bff;
        }

        .plan-item p {
            margin: 10px 0;
            color: #555;
        }

        .plan-item p strong {
            color: #333;
        }
    </style>
</head>

<body>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.plans.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Plan Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" required>
        </div>
        <div class="form-group">
            <label for="features">Features</label>
            <textarea class="form-control" name="features" id="features" required></textarea>
        </div>
        <button type="submit" class="btn-primary">Create Plan</button>
    </form>

    <div class="plans-grid">
        @foreach ($plans as $plan)
            <div class="plan-item">
                <strong>{{ $plan->name }}</strong>
                <p>{{ $plan->description }}</p>
                <p><strong>Price:</strong> ${{ $plan->price }}</p>
                <p><strong>Features:</strong> {{ $plan->features }}</p>
            </div>
        @endforeach
    </div>

</body>

</html>
