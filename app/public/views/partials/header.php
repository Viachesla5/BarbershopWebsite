<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hairsalon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#1E293B',
                            200: '#0F172A',
                            300: '#0B1222',
                            accent: '#3B82F6'
                        }
                    },
                    transitionProperty: {
                        'opacity': 'opacity',
                    },
                }
            }
        }
    </script>
    <style>
        /* Global styles */
        body {
            background-color: #0F172A;
            color: #E2E8F0;
        }

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

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1E293B;
        }
        ::-webkit-scrollbar-thumb {
            background: #3B82F6;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563EB;
        }

        /* Card and container styles */
        .dark-card {
            background-color: #1E293B;
            border: 1px solid #2D3748;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Form styles */
        .form-container {
            background-color: #1E293B;
            border: 1px solid #2D3748;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        input, select, textarea {
            background-color: #0F172A !important;
            border: 1px solid #2D3748 !important;
            color: #E2E8F0 !important;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: all 0.2s ease-in-out;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
            outline: none !important;
        }

        label {
            color: #E2E8F0;
            margin-bottom: 0.5rem;
            display: block;
            font-weight: 500;
        }

        /* Table styles */
        table {
            background-color: #1E293B;
            border-radius: 0.5rem;
            overflow: hidden;
            width: 100%;
            margin-bottom: 1.5rem;
        }

        th {
            background-color: #0F172A;
            color: #E2E8F0;
            font-weight: 600;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        td {
            padding: 0.75rem 1rem;
            color: #E2E8F0;
            border-bottom: 1px solid #2D3748;
        }

        tr:hover {
            background-color: #0F172A;
        }

        /* List styles */
        .list-container {
            background-color: #1E293B;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .list-item {
            padding: 0.75rem;
            border-bottom: 1px solid #2D3748;
            transition: all 0.2s ease-in-out;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .list-item:hover {
            background-color: #0F172A;
        }

        /* Button styles */
        .btn-primary {
            background-color: #3B82F6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #2563EB;
        }
        .btn-secondary {
            background-color: #1E293B;
            border: 1px solid #3B82F6;
            color: #3B82F6;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .btn-secondary:hover {
            background-color: #3B82F6;
            color: white;
        }

        /* Alert and message styles */
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid #10B981;
            color: #10B981;
        }
        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid #EF4444;
            color: #EF4444;
        }
        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border: 1px solid #F59E0B;
            color: #F59E0B;
        }

        /* Placeholder styles */
        ::placeholder {
            color: #4B5563 !important;
            opacity: 1;
        }
    </style>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
</head>

<body class="min-h-screen bg-dark-200">
    <?php require(__DIR__ . "/header_nav.php");
