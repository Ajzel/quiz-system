<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .btn { padding: 8px 16px; background: #3b82f6; color: white; border: none; cursor: pointer; text-decoration: none; border-radius: 4px; }
        .btn-green { background: #22c55e; }
        .btn-red { background: #ef4444; }
        input, textarea, select { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .alert { padding: 10px; background: #d1fae5; border: 1px solid #6ee7b7; margin-bottom: 16px; border-radius: 4px; }
        .card { border: 1px solid #e5e7eb; padding: 16px; margin-bottom: 12px; border-radius: 6px; }
    </style>
</head>
<body>
    <h2><a href="/" style="text-decoration:none;color:#1e293b;">📝 Quiz System</a></h2>
    <hr>
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @yield('content')
</body>
</html>