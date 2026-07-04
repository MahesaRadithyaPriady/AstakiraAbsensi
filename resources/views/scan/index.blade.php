<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mesin Absensi - Scan QR</title>
    @vite(['resources/css/app.css', 'resources/js/scan-machine.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="mx-auto max-w-4xl px-4 py-6">
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600">
                    <i data-lucide="scan-line" class="h-6 w-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold">Mesin Absensi</h1>
                    <p class="text-sm text-slate-400">Scan QR Code PKL</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div id="cam-status" class="flex items-center gap-2 rounded-lg bg-slate-800 px-3 py-1.5 text-sm">
                    <div class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></div>
                    <span id="cam-status-text" class="text-slate-300">Menghubungkan kamera...</span>
                </div>
            </div>
        </div>

        {{-- Camera feed + scan overlay --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-700 bg-black">
            <div class="relative aspect-[4/3] w-full">
                <img id="camera-feed" src="" alt="Camera" class="absolute inset-0 h-full w-full object-cover">
                <div id="camera-placeholder" class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="mb-4 h-12 w-12 animate-spin rounded-full border-2 border-slate-600 border-t-blue-500"></div>
                    <p class="text-sm text-slate-400">Menunggu kamera...</p>
                    <p class="mt-1 text-xs text-slate-500">http://{{ $cameraIp }}:{{ $cameraPort }}/</p>
                </div>

                {{-- Scan overlay --}}
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute left-1/2 top-1/2 h-48 w-48 -translate-x-1/2 -translate-y-1/2">
                        <div class="absolute left-0 top-0 h-6 w-6 border-l-4 border-t-4 border-blue-500 rounded-tl-lg"></div>
                        <div class="absolute right-0 top-0 h-6 w-6 border-r-4 border-t-4 border-blue-500 rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 h-6 w-6 border-b-4 border-l-4 border-blue-500 rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 h-6 w-6 border-b-4 border-r-4 border-blue-500 rounded-br-lg"></div>
                        <div id="scan-line" class="absolute left-0 right-0 top-0 h-0.5 bg-blue-500 shadow-[0_0_10px_2px_rgba(59,130,246,0.8)] animate-scan"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden canvas for QR decoding --}}
        <canvas id="scan-canvas" class="hidden"></canvas>

        {{-- Result display --}}
        <div id="result-area" class="mt-6 space-y-3"></div>

        {{-- Recent scans --}}
        <div class="mt-6">
            <h2 class="mb-3 text-sm font-semibold text-slate-400">Riwayat Scan Terakhir</h2>
            <div id="recent-scans" class="space-y-2 max-h-64 overflow-y-auto">
                <div class="rounded-xl border border-slate-800 bg-slate-900 px-4 py-3 text-center text-sm text-slate-500">
                    Belum ada scan.
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0; }
            50% { top: 100%; }
            100% { top: 0; }
        }
        .animate-scan {
            animation: scan 2s linear infinite;
        }
    </style>

    <script>
        const cameraFeed = document.getElementById('camera-feed');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const camStatus = document.getElementById('cam-status');
        const camStatusText = document.getElementById('cam-status-text');
        const scanCanvas = document.getElementById('scan-canvas');
        const scanCtx = scanCanvas.getContext('2d', { willReadFrequently: true });
        const resultArea = document.getElementById('result-area');
        const recentScans = document.getElementById('recent-scans');
        const scanHistory = [];
        let lastScanTime = 0;
        let snapshotTimer = null;
        const SCAN_COOLDOWN = 3000;
        const POLL_INTERVAL = 800;

        const cameraStreamUrl = 'http://{{ $cameraIp }}:{{ $cameraPort }}/video';
        const snapshotUrl = '/scan/snapshot';

        function setCamStatus(state, text) {
            const dot = camStatus.querySelector('div');
            dot.classList.remove('bg-amber-500', 'bg-emerald-500', 'bg-red-500', 'animate-pulse');
            if (state === 'connecting') {
                dot.classList.add('bg-amber-500', 'animate-pulse');
            } else if (state === 'connected') {
                dot.classList.add('bg-emerald-500');
            } else if (state === 'error') {
                dot.classList.add('bg-red-500', 'animate-pulse');
            }
            camStatusText.textContent = text;
        }

        // --- Video display: direct MJPEG stream from IP camera ---
        function startVideoStream() {
            cameraFeed.src = cameraStreamUrl + '?t=' + Date.now();
        }

        cameraFeed.onload = () => {
            cameraPlaceholder.classList.add('hidden');
            setCamStatus('connected', 'Kamera terhubung');
        };

        cameraFeed.onerror = () => {
            cameraPlaceholder.classList.remove('hidden');
            cameraPlaceholder.innerHTML = `
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-900/50">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm text-red-400 font-medium">Gagal menghubungkan kamera</p>
                    <p class="mt-1 text-xs text-slate-500">Pastikan IP camera aktif di ${cameraStreamUrl}</p>
                    <button onclick="startVideoStream()" class="mt-3 rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-700">Coba lagi</button>
                </div>`;
            setCamStatus('error', 'Kamera terputus');
        };

        // --- QR decode: fetch snapshot via Laravel proxy (no CORS issue) ---
        async function fetchSnapshotForDecode() {
            try {
                const res = await fetch(snapshotUrl + '?t=' + Date.now(), {
                    cache: 'no-store',
                });

                if (!res.ok) return;

                const blob = await res.blob();
                const url = URL.createObjectURL(blob);

                const img = new Image();
                img.onload = () => {
                    decodeQrFromImage(img);
                    URL.revokeObjectURL(url);
                };
                img.onerror = () => {
                    URL.revokeObjectURL(url);
                };
                img.src = url;
            } catch (e) {
                // silently continue
            }
        }

        function decodeQrFromImage(img) {
            const now = Date.now();
            if (now - lastScanTime < SCAN_COOLDOWN) return;

            try {
                scanCanvas.width = img.naturalWidth;
                scanCanvas.height = img.naturalHeight;
                scanCtx.drawImage(img, 0, 0, scanCanvas.width, scanCanvas.height);

                const imageData = scanCtx.getImageData(0, 0, scanCanvas.width, scanCanvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: 'attemptBoth',
                });

                if (code && code.data) {
                    lastScanTime = now;
                    processQrData(code.data);
                }
            } catch (e) {
                // silently continue
            }
        }

        function startPolling() {
            if (snapshotTimer) clearInterval(snapshotTimer);
            // Start video stream for display
            startVideoStream();
            // Start snapshot polling for QR decode
            fetchSnapshotForDecode();
            snapshotTimer = setInterval(fetchSnapshotForDecode, POLL_INTERVAL);
        }

        // --- Sound feedback ---
        let audioCtx = null;

        function beep(frequency, duration, type) {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.type = type || 'sine';
            osc.frequency.value = frequency;
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + duration);
            osc.start(audioCtx.currentTime);
            osc.stop(audioCtx.currentTime + duration);
        }

        function beepSuccess() {
            // Two short high beeps
            beep(880, 0.15, 'sine');
            setTimeout(() => beep(1175, 0.2, 'sine'), 160);
        }

        function beepError() {
            // One low buzz
            beep(220, 0.4, 'square');
        }

        async function processQrData(data) {
            let scanUrl = data;

            try {
                const parsed = JSON.parse(data);
                if (parsed.jenis) return;
            } catch (e) {}

            // Convert to relative URL to avoid CORS issues
            try {
                const url = new URL(scanUrl);
                scanUrl = url.pathname + url.search;
            } catch (e) {}

            showResult('scanning', 'Memproses QR...');

            try {
                const res = await fetch(scanUrl, {
                    headers: { 'Accept': 'application/json' },
                });
                const result = await res.json();

                if (res.ok && result.success) {
                    beepSuccess();
                    showResult('success', result.message || 'Absensi berhasil!');
                    addRecentScan('success', result.message || 'Berhasil', result.jam_masuk);
                } else {
                    beepError();
                    const msg = result.message || 'Gagal memproses absensi.';
                    showResult('error', msg);
                    addRecentScan('error', msg, null);
                }
            } catch (e) {
                beepError();
                showResult('error', 'Gagal terhubung ke server.');
                addRecentScan('error', 'Gagal terhubung ke server', null);
            }
        }

        function showResult(type, message) {
            const colors = {
                success: { bg: 'bg-emerald-900/50', border: 'border-emerald-600', text: 'text-emerald-300', icon: 'check-circle' },
                error: { bg: 'bg-red-900/50', border: 'border-red-600', text: 'text-red-300', icon: 'x-circle' },
                scanning: { bg: 'bg-blue-900/50', border: 'border-blue-600', text: 'text-blue-300', icon: 'loader' },
            };
            const c = colors[type] || colors.error;

            resultArea.innerHTML = `
                <div class="flex items-center gap-3 rounded-xl border ${c.border} ${c.bg} px-4 py-3">
                    <i data-lucide="${c.icon}" class="h-5 w-5 ${c.text} ${type === 'scanning' ? 'animate-spin' : ''}"></i>
                    <p class="text-sm font-medium ${c.text}">${message}</p>
                </div>`;
            if (window.lucide) lucide.createIcons();

            if (type === 'success') {
                setTimeout(() => { resultArea.innerHTML = ''; }, 5000);
            }
        }

        function addRecentScan(type, message, jamMasuk) {
            scanHistory.unshift({ type, message, jamMasuk, time: new Date().toLocaleTimeString('id-ID') });
            if (scanHistory.length > 10) scanHistory.pop();

            recentScans.innerHTML = scanHistory.map(s => {
                const color = s.type === 'success' ? 'border-emerald-700 bg-emerald-900/30' : 'border-red-700 bg-red-900/30';
                const icon = s.type === 'success' ? 'check-circle' : 'x-circle';
                const textColor = s.type === 'success' ? 'text-emerald-300' : 'text-red-300';
                return `
                    <div class="flex items-center gap-3 rounded-xl border ${color} px-4 py-2.5">
                        <i data-lucide="${icon}" class="h-4 w-4 ${textColor}"></i>
                        <div class="flex-1">
                            <p class="text-sm ${textColor}">${s.message}</p>
                        </div>
                        <span class="text-xs text-slate-500">${s.time}</span>
                    </div>`;
            }).join('');

            if (window.lucide) lucide.createIcons();
        }

        startPolling();
    </script>
</body>
</html>
