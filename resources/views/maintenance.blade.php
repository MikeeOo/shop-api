<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Service Temporarily Unavailable' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            line-height: 1.6;
        }

        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            margin: 2rem;
        }

        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .maintenance-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .maintenance-message {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .maintenance-details {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 2rem;
        }

        .retry-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .retry-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .status-code {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        .footer-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 0.8rem;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .maintenance-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .maintenance-title {
                font-size: 1.5rem;
            }

            .maintenance-icon {
                font-size: 3rem;
            }
        }

        /* Loading animation */
        .loading-dots {
            display: inline-block;
            margin-left: 0.5rem;
        }

        .loading-dots::after {
            content: '';
            animation: loading 2s infinite;
        }

        @keyframes loading {
            0% {
                content: '';
            }

            25% {
                content: '.';
            }

            50% {
                content: '..';
            }

            75% {
                content: '...';
            }

            100% {
                content: '';
            }
        }
    </style>
</head>

<body>
    <div class="maintenance-container">
        <div class="status-code">HTTP {{ $statusCode ?? '503' }}</div>

        <div class="maintenance-icon">
            {{ $icon ?? '🔧' }}
        </div>

        <h1 class="maintenance-title">
            {{ $title ?? 'Service Temporarily Unavailable' }}
        </h1>

        <p class="maintenance-message">
            {{ $message ?? "We're currently performing scheduled maintenance to improve your experience. Please check back in a few minutes." }}
        </p>

        @if (isset($details))
            <p class="maintenance-details">
                {{ $details }}
            </p>
        @endif

        <button class="retry-button" onclick="window.location.reload()">
            Try Again
        </button>

        <div class="footer-info">
            <p>
                If this issue persists, please contact support<span class="loading-dots"></span>
            </p>
            @if (config('app.debug'))
                <p style="margin-top: 0.5rem; font-size: 0.7rem;">
                    Request ID: {{ Str::random(8) }}
                </p>
            @endif
        </div>
    </div>

    <script>
        // Auto-retry every 30 seconds in production
        @if (!config('app.debug'))
            setTimeout(() => {
                window.location.reload();
            }, 30000);
        @endif

        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.maintenance-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';

            setTimeout(() => {
                container.style.transition = 'all 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>

</html>
