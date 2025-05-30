<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Buscador de correos</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  @vite(['resources/js/pages/emailSearch.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen py-12">
  <div class="container mx-auto px-4 max-w-2xl">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Buscador de correos</h1>
    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="flex gap-2">
        <input type="text" id="search" placeholder="Buscar correo" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button id="search-button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Buscar</button>
      </div>
      <ul id="results" class="mt-6 space-y-2"></ul>
    </div>
  </div>
</body>
</html>