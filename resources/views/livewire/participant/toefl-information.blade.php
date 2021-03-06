<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 justify-center text-center">
                        Informasi Pendaftaran dan Kelas
                    </h3>
                    <p class="mt-1 text-center text-sm text-gray-500">
                        Status Pendaftaran dan Pelaksanaan TOEFL
                    </p>
                </div>
                <div wire:poll="checkStatusPermission" class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Kelas
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $user->kelas->nama }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Tanggal Mendaftar
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $user->created_at->isoFormat('HH:mm, dddd, D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Pelaksanaan TOEFL
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $user->kelas->pelaksanaan->isoFormat('H:mm, dddd, D MMMM Y') }} ({{ $user->kelas->pelaksanaan->diffForHumans() }}) 
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Batas Akhir Waktu Pelaksanaan TOEFL
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $user->kelas->akhir_pelaksanaan->isoFormat('H:mm, dddd, D MMMM Y') }} ({{ $user->kelas->akhir_pelaksanaan->diffForHumans() }}) 
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status Pendaftaran
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $user->status->status }}
                            </dd>
                        </div>
            
                        {{-- kalau ada permission mengerjakan, maka tampilkan tombol atau komponen tombol --}}
                        @can('mengerjakan toefl')
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Lembar Kerja TOEFL
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2">
                                : <button wire:click="startToefl" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">mulai soal</button>
                            </dd>
                        </div>
                        @endcan
                    
                        {{-- kalau ada melihat skor (sudah selesai mengerjakan) --}}
                        @can('melihat skor')
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Hasil Kerja TOEFL
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @livewire('toefl.toefl-score', ['user' => $user], key($user->id))
                            </dd>
                        </div>
                        @endcan
                      
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Attachments
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: solid/paper-clip -->
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                bukti pembayaran
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button wire:click="downloadReceipt" class="font-medium text-indigo-600 hover:text-indigo-500">Download</button>
                                        </div>
                                    </li>
            
                                    {{-- download certificate kalau udah selesai mengerjakan --}}
                                    @if ($user->certificate)
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: solid/paper-clip -->
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                sertifikat toefl
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button wire:click="downloadCertificate" class="font-medium text-indigo-600 hover:text-indigo-500">Download</button>
                                        </div>
                                    </li>
                                    @endif
                                    
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

