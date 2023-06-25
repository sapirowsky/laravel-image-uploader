<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <title>Dodaj plik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])

</head>
<body>
    <div class="max-w-lg mx-auto mt-24">
        <h1 class="text-4xl font-bold text-center">Dodawanie zdjęć</h1>
        <div id="app"></div>
    </div>
  
</body>
</html>