<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakBaik - Catat Langkah Literasimu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex flex-col h-screen items-center justify-center">
    <div class="pb-3">
        <div class="text-6xl font-bold text-amber-500">Jejak<span class="text-slate-800">Baik</span></div>
        <div class="items-end justify-center text-right text-xs">by <span class="text-amber-500 font-bold">ParahyanganSchool</span></div>
    </div>
    <div class>

        


        <div class="flex space-x-2">
            <div class="bg-neutral-primary-soft block max-w-sm border border-default shadow-xl rounded-md">
                <img class="" src="{{ asset('storage/card.png')  }}" alt="" />

                <div class="p-6 text-center">
                    <span class="inline-flex items-center bg-slate-200 border rounded-md text-slate-500 px-3">
                        <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.122 17.645a7.185 7.185 0 0 1-2.656 2.495 7.06 7.06 0 0 1-3.52.853 6.617 6.617 0 0 1-3.306-.718 6.73 6.73 0 0 1-2.54-2.266c-2.672-4.57.287-8.846.887-9.668A4.448 4.448 0 0 0 8.07 6.31 4.49 4.49 0 0 0 7.997 4c1.284.965 6.43 3.258 5.525 10.631 1.496-1.136 2.7-3.046 2.846-6.216 1.43 1.061 3.985 5.462 1.754 9.23Z"/></svg>
                        ParaPoint
                    </span>
                    <a href="#">
                        <h5 class="mt-3 mb-6 text-md font-semibold tracking-tight text-heading">Catat Point Penghargaan dan Pelanggaran Siswa</h5>
                    </a>
                    <a href="/parapoint" class="inline-flex items-center bg-amber-500 text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-md text-sm px-4 py-2.5 focus:outline-none">
                        Log In
                        <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>

    
</body>
</html>