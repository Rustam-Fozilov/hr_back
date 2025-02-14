<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-dots-darker">

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="text-xl-center font-bold">iDocs</div>
    @if($errors->any())
        {!! implode('', $errors->all('<div style="color: red;">:message</div>')) !!}
    @endif
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="/login">
            @csrf
            <div>
                <label class="block font-medium text-sm text-gray-700" for="email">
                    Phone
                </label>
                <input style="padding: .5rem .75rem" class="border-gray-300 border focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="phone" type="text" name="phone" required="required" autofocus="autofocus" autocomplete="username">
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700" for="password">
                    Password
                </label>
                <input  style="padding: .5rem .75rem" class="border-gray-300 border focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="current-password">
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">
                    Log in
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
