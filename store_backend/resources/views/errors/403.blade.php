<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');
        
        body {
            background: radial-gradient(circle at center, #150f0a 0%, #080605 100%);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Decorative glowing circles */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 122, 0, 0.15);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            filter: blur(80px);
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 122, 0, 0.1);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
            filter: blur(80px);
            z-index: 0;
        }

        .error-container {
            background: rgba(20, 16, 14, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 122, 0, 0.15);
            border-radius: 24px;
            padding: 48px;
            text-align: center;
            max-width: 550px;
            width: 90%;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            z-index: 10;
            position: relative;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .error-container:hover {
            border-color: rgba(255, 122, 0, 0.3);
            box-shadow: 0 25px 60px rgba(255, 122, 0, 0.1);
        }

        .lock-icon {
            font-size: 80px;
            color: #FF7A00;
            margin-bottom: 24px;
            animation: pulse 2s infinite ease-in-out;
            text-shadow: 0 0 20px rgba(255, 122, 0, 0.4);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        h1 {
            font-size: 72px;
            font-weight: 800;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #fff 0%, #aaa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            font-size: 20px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .error-message {
            color: rgba(255, 255, 255, 0.6);
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .user-badge {
            background: rgba(255, 122, 0, 0.08);
            border: 1px solid rgba(255, 122, 0, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 32px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .user-badge i {
            color: #FF7A00;
        }

        .user-badge strong {
            color: #fff;
        }

        .btn-group-custom {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #FF9E44 0%, #FF7A00 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 122, 0, 0.5);
            background: linear-gradient(135deg, #FFB066 0%, #FF8F22 100%);
        }

        .btn-secondary-custom {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="lock-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1>403</h1>
        <h2>Forbidden Area</h2>
        
        <p class="error-message">
            {{ $exception->getMessage() ?: 'Unauthorized. This area is reserved for Platform Executives.' }}
        </p>

        @if(auth()->check())
            <div class="user-badge">
                <i class="fa-solid fa-user-circle"></i>
                <span>Logged in as: <strong>{{ auth()->user()->email }}</strong> (Role: <span class="text-capitalize">{{ auth()->user()->role }}</span>)</span>
            </div>
        @endif

        <div class="btn-group-custom">
            <a href="{{ url('/test-admin') }}" class="btn-primary-custom">
                <i class="fa-solid fa-user-shield"></i> Auto-Login as System Director
            </a>
            
            <div class="d-flex gap-2">
                <a href="{{ url('/') }}" class="btn-secondary-custom flex-grow-1">
                    <i class="fa-solid fa-house"></i> Home
                </a>
                <a href="{{ url('/logout') }}" class="btn-secondary-custom flex-grow-1 text-danger border-danger-subtle">
                    <i class="fa-solid fa-power-off"></i> Log Out
                </a>
            </div>
        </div>
    </div>

</body>
</html>
