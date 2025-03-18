<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hairsalon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    transitionProperty: {
                        'opacity': 'opacity',
                    },
                }
            }
        }
    </script>
    <style>
        /* Custom hover effects */
        .hover-trigger {
            position: relative;
            cursor: pointer;
        }
        .hover-trigger img {
            transition: opacity 0.2s ease-in-out;
        }
        .hover-trigger:hover img {
            opacity: 0.75;
        }
        .hover-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }
        .hover-trigger:hover .hover-overlay {
            opacity: 1;
        }
    </style>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
</head>

<body>
    <?php require(__DIR__ . "/header_nav.php");
