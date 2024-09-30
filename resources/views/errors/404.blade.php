<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            text-align: center;
        }

        .error-container {
            animation: fadeIn 1s ease;
        }

        h1 {
            font-size: 6rem;
            color: #dc3545;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1.2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>404</h1>
        <p><i class="fas fa-exclamation-triangle"></i> Oops! Halaman yang kamu cari tidak ditemukan.</p>
        <a href="/" class="btn btn-danger">Kembali ke Home</a>
    </div>
</body>

</html>
