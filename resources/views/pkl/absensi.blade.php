@extends('pkl.layout')

@section('title', 'Absensi')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-navy">Absensi</h1>
        <p class="mt-1 text-sm text-slate-500">{{ now()->format('l, d F Y') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="check-circle" class="h-4 w-4"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <i data-lucide="alert-circle" class="h-4 w-4"></i>
            <span>Periksa kembali data yang dimasukkan.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- QR Code Absensi --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">QR Code Absensi</h2>
                <i data-lucide="qr-code" class="h-5 w-5 text-slate-400"></i>
            </div>

            <div class="p-6">
                @if ($izinSakitToday && $izinSakitToday->status_approval === 'approved')
                    {{-- Sudah izin/sakit disetujui --}}
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                            <i data-lucide="file-text" class="h-8 w-8 text-amber-600"></i>
                        </div>
                        <h3 class="text-base font-semibold text-slate-700">
                            Anda sedang {{ $izinSakitToday->jenis === 'izin' ? 'izin' : 'sakit' }}
                        </h3>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ $izinSakitToday->tanggal->format('d M Y') }}
                            @if ($izinSakitToday->sampai_tanggal)
                                s/d {{ $izinSakitToday->sampai_tanggal->format('d M Y') }}
                            @endif
                        </p>
                        <p class="mt-1 text-sm text-slate-400">Pengajuan telah disetujui oleh admin. Tidak dapat absensi sampai masa izin/sakit berakhir.</p>
                    </div>
                @elseif ($absensiToday && $absensiToday->jam_masuk)
                    {{-- Sudah absen --}}
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                            <i data-lucide="check-circle" class="h-8 w-8 text-emerald-600"></i>
                        </div>
                        <h3 class="text-base font-semibold text-slate-700">Sudah Absen Hari Ini</h3>
                        <p class="mt-1 text-sm text-slate-400">
                            Jam masuk: <span class="font-semibold text-slate-600">{{ \Carbon\Carbon::parse($absensiToday->jam_masuk)->format('H:i') }} WIB</span>
                        </p>
                    </div>
                @else
                    {{-- Belum absen, tampilkan QR --}}
                    <div class="flex flex-col items-center">
                        <div id="qr-container" class="mb-4 flex flex-col items-center">
                            <div id="qr-loading" class="flex h-64 w-64 items-center justify-center rounded-xl bg-slate-50">
                                <div class="text-center">
                                    <div class="mx-auto mb-3 h-8 w-8 animate-spin rounded-full border-2 border-slate-300 border-t-brand-blue"></div>
                                    <p class="text-sm text-slate-400">Memuat QR...</p>
                                </div>
                            </div>
                            <div id="qr-display" class="hidden rounded-xl border-2 border-slate-200 bg-white p-4">
                                <canvas id="qr-canvas"></canvas>
                            </div>
                        </div>

                        {{-- Timer --}}
                        <div id="qr-timer" class="hidden mb-4 flex items-center gap-2">
                            <i data-lucide="clock" class="h-4 w-4 text-slate-400"></i>
                            <span class="text-sm font-medium text-slate-600">QR berlaku selama <span id="timer-text" class="font-bold text-brand-blue">60</span> detik</span>
                        </div>

                        {{-- Waiting for scan --}}
                        <div id="qr-waiting" class="hidden mb-4 flex items-center gap-2">
                            <div class="h-3 w-3 animate-pulse rounded-full bg-brand-blue"></div>
                            <span class="text-sm font-medium text-slate-600">Menunggu scan dari mesin absensi...</span>
                        </div>

                        {{-- Scanned success --}}
                        <div id="qr-scanned" class="hidden mb-4 flex flex-col items-center">
                            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100">
                                <i data-lucide="check-circle" class="h-6 w-6 text-emerald-600"></i>
                            </div>
                            <p class="text-sm font-medium text-emerald-600">Absensi Berhasil!</p>
                            <p id="scanned-time" class="text-xs text-slate-400"></p>
                        </div>

                        {{-- Expired --}}
                        <div id="qr-expired" class="hidden mb-4 flex flex-col items-center">
                            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                <i data-lucide="x-circle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <p class="text-sm font-medium text-red-600">QR Code telah kedaluwarsa</p>
                        </div>

                        {{-- Retry button --}}
                        <button id="qr-retry" class="hidden inline-flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
                            <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                            Retry Absensi
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form Izin/Sakit --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">Pengajuan Izin / Sakit</h2>
                <i data-lucide="file-text" class="h-5 w-5 text-slate-400"></i>
            </div>

            @if ($izinSakitToday)
                <div class="p-6">
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full
                            {{ $izinSakitToday->status_approval === 'pending' ? 'bg-amber-100' : ($izinSakitToday->status_approval === 'approved' ? 'bg-emerald-100' : 'bg-red-100') }}">
                            @if ($izinSakitToday->status_approval === 'pending')
                                <i data-lucide="clock" class="h-8 w-8 text-amber-600"></i>
                            @elseif ($izinSakitToday->status_approval === 'approved')
                                <i data-lucide="check-circle" class="h-8 w-8 text-emerald-600"></i>
                            @else
                                <i data-lucide="x-circle" class="h-8 w-8 text-red-600"></i>
                            @endif
                        </div>
                        <h3 class="text-base font-semibold text-slate-700">
                            Pengajuan {{ $izinSakitToday->jenis === 'izin' ? 'Izin' : 'Sakit' }}
                        </h3>
                        <p class="mt-1 text-sm text-slate-400">{{ $izinSakitToday->keterangan }}</p>
                        <span class="mt-3 rounded-full px-3 py-1 text-xs font-medium
                            {{ $izinSakitToday->status_approval === 'pending' ? 'bg-amber-100 text-amber-700' : ($izinSakitToday->status_approval === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($izinSakitToday->status_approval) }}
                        </span>
                    </div>
                </div>
            @else
                <form action="{{ route('pkl.absensi.izin') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="space-y-5">
                        {{-- Jenis --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Jenis <span class="text-red-500">*</span></label>
                            <div class="flex gap-3" id="jenis-group">
                                <label class="jenis-label flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition-all hover:border-primary-400 hover:bg-primary-50/50">
                                    <input type="radio" name="jenis" value="izin" class="sr-only" required>
                                    <i data-lucide="calendar-off" class="h-4 w-4"></i>
                                    Izin
                                </label>
                                <label class="jenis-label flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition-all hover:border-primary-400 hover:bg-primary-50/50">
                                    <input type="radio" name="jenis" value="sakit" class="sr-only">
                                    <i data-lucide="heart-pulse" class="h-4 w-4"></i>
                                    Sakit
                                </label>
                            </div>
                        </div>

                        {{-- Tanggal Mulai (read-only, hari ini) --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                            <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">
                            <input type="text" value="{{ now()->format('d M Y') }}"
                                   class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-500" readonly>
                            <p class="mt-1 text-xs text-slate-400">Otomatis hari ini, tidak bisa diubah.</p>
                        </div>

                        {{-- Sampai Tanggal --}}
                        <div>
                            <label for="sampai_tanggal" class="mb-1.5 block text-sm font-medium text-slate-700">Sampai Tanggal <span class="text-slate-400 text-xs font-normal">(opsional)</span></label>
                            <input type="date" id="sampai_tanggal" name="sampai_tanggal" value="{{ old('sampai_tanggal') }}" min="{{ now()->format('Y-m-d') }}"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('sampai_tanggal') border-red-400 @enderror">
                            <p class="mt-1 text-xs text-slate-400">Kosongkan jika hanya untuk hari ini.</p>
                            @error('sampai_tanggal') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- QR Preview Izin/Sakit --}}
                        <div id="izin-qr-preview" class="hidden rounded-xl border-2 border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 text-center text-xs font-medium text-slate-500">Preview QR Pengajuan</p>
                            <div class="flex justify-center">
                                <canvas id="izin-qr-canvas"></canvas>
                            </div>
                            <div id="izin-qr-info" class="mt-3 text-center text-xs text-slate-400"></div>
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <label for="keterangan" class="mb-1.5 block text-sm font-medium text-slate-700">Keterangan <span class="text-red-500">*</span></label>
                            <textarea id="keterangan" name="keterangan" rows="3"
                                      class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('keterangan') border-red-400 @enderror"
                                      placeholder="Alasan izin/sakit" required>{{ old('keterangan') }}</textarea>
                            @error('keterangan') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Surat --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Surat / Bukti <span class="text-red-500">*</span></label>
                            <div id="surat-drop-zone" class="relative flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition-all hover:border-primary-400 hover:bg-primary-50/50">
                                <input type="file" id="surat" name="surat" accept="image/*,.pdf"
                                       class="absolute inset-0 h-full w-full cursor-pointer opacity-0 @error('surat') border-red-400 @enderror" required>
                                <div class="pointer-events-none text-center">
                                    <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-100">
                                        <i data-lucide="upload-cloud" class="h-5 w-5 text-brand-blue"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-600">Drag & drop atau <span class="text-brand-blue">klik untuk pilih</span></p>
                                    <p class="mt-1 text-xs text-slate-400">Format: JPG, PNG, PDF. Maks 2MB.</p>
                                </div>
                            </div>
                            @error('surat') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
                            <i data-lucide="send" class="h-4 w-4"></i>
                            Ajukan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    {{-- Riwayat --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Riwayat Absensi --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">Riwayat Absensi</h2>
                <i data-lucide="history" class="h-5 w-5 text-slate-400"></i>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($riwayatAbsensi as $absensi)
                    <div class="flex items-center justify-between px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100">
                                <i data-lucide="check" class="h-4 w-4 text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $absensi->tanggal->format('d M Y') }}</p>
                                <p class="text-xs text-slate-400">Masuk: {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Hadir</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada riwayat absensi.</div>
                @endforelse
            </div>
        </div>

        {{-- Riwayat Izin/Sakit --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">Riwayat Izin/Sakit</h2>
                <i data-lucide="file-text" class="h-5 w-5 text-slate-400"></i>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($riwayatIzin as $izin)
                    <div class="flex items-center justify-between px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full
                                {{ $izin->jenis === 'sakit' ? 'bg-red-100' : 'bg-amber-100' }}">
                                <i data-lucide="{{ $izin->jenis === 'sakit' ? 'heart-pulse' : 'calendar-off' }}" class="h-4 w-4
                                   {{ $izin->jenis === 'sakit' ? 'text-red-600' : 'text-amber-600' }}"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ ucfirst($izin->jenis) }} - {{ $izin->tanggal->format('d M Y') }}{{ $izin->sampai_tanggal ? ' s/d ' . $izin->sampai_tanggal->format('d M Y') : '' }}</p>
                                <p class="text-xs text-slate-400">{{ Str::limit($izin->keterangan, 40) }}</p>
                            </div>
                        </div>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                            {{ $izin->status_approval === 'pending' ? 'bg-amber-100 text-amber-700' : ($izin->status_approval === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($izin->status_approval) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada riwayat izin/sakit.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@vite(['resources/js/pkl-absensi.js'])
<script>
    const qrLoading = document.getElementById('qr-loading');
    const qrDisplay = document.getElementById('qr-display');
    const qrCanvas = document.getElementById('qr-canvas');
    const qrTimer = document.getElementById('qr-timer');
    const timerText = document.getElementById('timer-text');
    const qrExpired = document.getElementById('qr-expired');
    const qrRetry = document.getElementById('qr-retry');
    const qrWaiting = document.getElementById('qr-waiting');
    const qrScanned = document.getElementById('qr-scanned');
    const scannedTime = document.getElementById('scanned-time');
    let timerInterval = null;
    let pollInterval = null;
    let currentToken = null;

    async function generateQr() {
        qrLoading.classList.remove('hidden');
        qrDisplay.classList.add('hidden');
        qrTimer.classList.add('hidden');
        qrExpired.classList.add('hidden');
        qrRetry.classList.add('hidden');
        qrWaiting.classList.add('hidden');
        qrScanned.classList.add('hidden');
        clearInterval(pollInterval);

        try {
            const res = await fetch('/pkl/absensi/qr', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();

            if (!res.ok && data.error) {
                qrLoading.classList.add('hidden');
                qrExpired.classList.remove('hidden');
                const expiredP = qrExpired.querySelector('p');
                if (expiredP) expiredP.textContent = data.error;
                return;
            }

            currentToken = data.token;

            qrLoading.classList.add('hidden');
            qrDisplay.classList.remove('hidden');
            qrTimer.classList.remove('hidden');
            qrWaiting.classList.remove('hidden');

            QRCode.toCanvas(qrCanvas, data.qr_data, {
                width: 256,
                margin: 2,
                color: { dark: '#1e293b', light: '#ffffff' },
            }, function (error) {
                if (error) console.error(error);
            });

            startTimer(60);
            startPolling(data.token);
        } catch (e) {
            console.error(e);
            qrLoading.classList.add('hidden');
            qrExpired.classList.remove('hidden');
            qrRetry.classList.remove('hidden');
        }
    }

    function startPolling(token) {
        clearInterval(pollInterval);
        pollInterval = setInterval(async () => {
            try {
                const res = await fetch('/pkl/absensi/check/' + token, {
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json();

                if (data.scanned) {
                    clearInterval(pollInterval);
                    clearInterval(timerInterval);
                    qrDisplay.classList.add('hidden');
                    qrTimer.classList.add('hidden');
                    qrWaiting.classList.add('hidden');
                    qrScanned.classList.remove('hidden');
                    scannedTime.textContent = 'Jam masuk: ' + data.jam_masuk + ' WIB';
                    setTimeout(() => location.reload(), 2000);
                }
            } catch (e) {
                console.error(e);
            }
        }, 3000);
    }

    function startTimer(seconds) {
        clearInterval(timerInterval);
        let remaining = seconds;
        timerText.textContent = remaining;

        timerInterval = setInterval(() => {
            remaining--;
            timerText.textContent = remaining;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                clearInterval(pollInterval);
                qrDisplay.classList.add('hidden');
                qrTimer.classList.add('hidden');
                qrWaiting.classList.add('hidden');
                qrExpired.classList.remove('hidden');
                qrRetry.classList.remove('hidden');
            }
        }, 1000);
    }

    if (qrRetry) {
        qrRetry.addEventListener('click', generateQr);
    }

    // --- Izin/Sakit QR Preview ---
    const jenisLabels = document.querySelectorAll('.jenis-label');
    const sampaiTanggalInput = document.getElementById('sampai_tanggal');
    const izinQrPreview = document.getElementById('izin-qr-preview');
    const izinQrCanvas = document.getElementById('izin-qr-canvas');
    const izinQrInfo = document.getElementById('izin-qr-info');
    const todayDate = '{{ now()->format("Y-m-d") }}';
    const todayDisplay = '{{ now()->format("d M Y") }}';

    function updateJenisStyle() {
        jenisLabels.forEach(label => {
            const radio = label.querySelector('input[type="radio"]');
            if (radio.checked) {
                label.classList.add('border-brand-blue', 'bg-primary-50', 'text-brand-blue');
                label.classList.remove('border-slate-200', 'text-slate-600');
            } else {
                label.classList.remove('border-brand-blue', 'bg-primary-50', 'text-brand-blue');
                label.classList.add('border-slate-200', 'text-slate-600');
            }
        });
    }

    function updateIzinQr() {
        const checked = document.querySelector('input[name="jenis"]:checked');
        if (!checked) {
            izinQrPreview.classList.add('hidden');
            return;
        }

        const jenis = checked.value;
        const sampai = sampaiTanggalInput.value;

        izinQrPreview.classList.remove('hidden');

        const qrData = JSON.stringify({
            jenis: jenis,
            tanggal: todayDate,
            sampai_tanggal: sampai || null,
        });

        QRCode.toCanvas(izinQrCanvas, qrData, {
            width: 200,
            margin: 2,
            color: { dark: jenis === 'sakit' ? '#dc2626' : '#d97706', light: '#ffffff' },
        }, function (error) {
            if (error) console.error(error);
        });

        let infoText = ucfirst(jenis) + ' - ' + todayDisplay;
        if (sampai) {
            infoText += ' s/d ' + formatDate(sampai);
        }
        izinQrInfo.textContent = infoText;
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function formatDate(dateStr) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const d = new Date(dateStr);
        return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    jenisLabels.forEach(label => {
        label.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            updateJenisStyle();
            updateIzinQr();
        });
    });

    if (sampaiTanggalInput) {
        sampaiTanggalInput.addEventListener('change', updateIzinQr);
    }

    @if (!$izinSakitToday && !($absensiToday && $absensiToday->jam_masuk))
        generateQr();
    @elseif ($izinSakitToday && $izinSakitToday->status_approval !== 'approved' && !($absensiToday && $absensiToday->jam_masuk))
        generateQr();
    @endif
</script>
@endpush
