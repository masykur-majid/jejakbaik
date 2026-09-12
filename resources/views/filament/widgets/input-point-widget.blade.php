<x-filament-widgets::widget>
<div class="w-full col-span-full space-y-0 mb-0 mt-5">
    <div class="pl-1">
        <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white sm:text-xl">
            {{ $this->getWidgetTitle() }}
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-center items-stretch  py-4 ">
        <!-- CARD 1: Berdasarkan Siswa -->
        <a href="{{ $this->inputByStudent()->getUrl() }}" class="inline-flex gap-4 items-center text-center bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-md transition group">
            <div class=" p-3 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl group-hover:scale-110 transition duration-200">
                <x-filament::icon icon="tabler-user-plus" class="h-12 w-12" />
            </div>
            <div class="">
                <h3 class="text-sm font-bold text-indigo-700 dark:text-white text-left">Input Berdasarkan Siswa</h3>
                <p class="text-[0.7rem] text-gray-500 dark:text-gray-400 text-left">Input satu siswa yang melakukan beberapa aturan poin</p>
            </div>

        </a>

        <a href="{{ $this->inputByConduct()->getUrl() }}" class="inline-flex gap-4 items-center text-center bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-md transition group">
            <div class=" p-3 bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 rounded-xl group-hover:scale-110 transition duration-200">
                <x-filament::icon icon="tabler-gavel" class="h-12 w-12" />
            </div>
            <div class="">
                <h3 class="text-sm font-bold text-rose-600 dark:text-white text-left">Input Berdasarkan Aturan</h3>
                <p class="text-[0.7rem] text-gray-500 dark:text-gray-400 text-left">Input satu aturan poin yang dilakukan oleh beberapa siswa</p>
            </div>

        </a>

        <a href="{{ $this->inputForAClass()->getUrl() }}" class="inline-flex gap-4 items-center text-center bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-md transition group">
            <div class=" p-3 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 rounded-xl group-hover:scale-110 transition duration-200">
                <x-filament::icon icon="tabler-users-group" class="h-12 w-12" />
            </div>
            <div class="">
                <h3 class="text-sm font-bold text-amber-600 dark:text-white text-left">Input Untuk Satu Kelas</h3>
                <p class="text-[0.7rem] text-gray-500 dark:text-gray-400 text-left">Input aturan poin yang dilakukan oleh satu kelas</p>
            </div>

        </a>
    </div>
</div>
</x-filament-widgets::widget>
