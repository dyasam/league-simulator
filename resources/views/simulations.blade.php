<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulations - Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-8">
<div id="app" class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">League Simulations</h1>
            <a href="/"
               class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105">
                Back to Teams
            </a>
        </div>
        <simulations-view></simulations-view>
    </div>
</div>
</body>
</html>
