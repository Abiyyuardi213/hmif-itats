<div id="logoutModal" data-modal role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-950/60 p-4 backdrop-blur-xs">
    <div class="w-full max-w-md rounded-2xl border border-line bg-white p-6 shadow-2xl">
        <h3 id="logoutModalTitle" class="font-display text-lg font-bold text-ink-950">Konfirmasi Keluar</h3>
        <p class="mt-2 text-sm text-ink-500">
            Apakah Anda yakin ingin mengakhiri sesi pengurus saat ini?
        </p>
        <div class="mt-6 flex items-center justify-end gap-3">
            <button type="button" data-modal-close class="rounded-lg border border-line px-4 py-2 text-sm font-medium text-ink-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>
